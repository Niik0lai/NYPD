<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;

class InstallerController extends Controller
{
     public function index()
    {
        return view('installer.installer');
    }

        public function do_install(Request $request){
         //return $request->all();

         $request->validate([
            'host'       => 'required',
            'dbuser'       => 'required',
            'dbname'       => 'required',
            'first_name'       => 'required',
            'last_name'       => 'required',
            'email'       => 'required|email',
            'password'       => 'required'
        ]);

        ini_set('max_execution_time', 300); //300 seconds
        $host           = $request->host;
        $dbuser         = $request->dbuser;
        $dbpassword     = $request->dbpassword;
        $dbname         = $request->dbname;
        $weburl         = $request->weburl;
        $first_name     = $request->first_name;
        $last_name      = $request->last_name;
        $admin_name     = $request->first_name.' '.$request->last_name;
        $email          = $request->email;
        $login_password = $request->password ? $request->password : "";

        $purchase_code  = $request->purchase_code;

        //check required fields
        // if (!($host && $dbuser && $dbname && $first_name && $last_name && $email && $login_password && $purchase_code)) {
        //     echo json_encod.e(array("success" => false, "message" => "Please input all fields."));
        //     exit();
        // }

        //check for valid database connection
        $mysqli = @new \mysqli($host, $dbuser, $dbpassword, $dbname);

        if (mysqli_connect_errno()) {

            return redirect()->back()->with('error', 'Please input valid database information.')->withInput($request->all());
            // echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
            // exit();
        }
        $mysqli->close();

        //check for valid email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return redirect()->back()->with('error', 'Please input a valid email.')->withInput($request->all());
            // echo json_encode(array("success" => false, "message" => "Please input a valid email."));
            // exit();
        }

        // validate purchase code
        $verification = $this->valid_purchase_code($purchase_code);
        if (!$verification || $verification != "verified") {
            return redirect()->back()->with('error', 'Please enter a valid purchase code.')->withInput($request->all());
            // echo json_encode(array("success" => false, "message" => "Please enter a valid purchase code."));
            // exit();
        }

        //  set database details
        $this->endWrite('DB_HOST', $host);
        $this->endWrite('DB_DATABASE', $dbname);
        $this->endWrite('DB_USERNAME', $dbuser);
        $this->endWrite('DB_PASSWORD', $dbpassword);
        sleep(3);

        Session::put('email', $email);
        Session::put('first_name', $first_name);
        Session::put('last_name', $last_name);
        Session::put('login_password', $login_password);
        Session::put('weburl', $weburl);
        //return Session::get('first_name');
        return redirect()->route('final');

    }

    public function finish(){

     // return Session::get('first_name');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
       foreach(\DB::select('SHOW TABLES') as $table) {
           $table_array = get_object_vars($table);
           \Schema::drop($table_array[key($table_array)]);
       }


        \Artisan::call('key:generate');
        \Artisan::call('config:clear');
        \Artisan::call('migrate:refresh');
        \Artisan::call('db:seed');
        \Artisan::call('storage:link');
       

        $user                = new User();
        $user->name         = Session::get('first_name');
        $user->img          = null;
        $user->noms         = Session::get('first_name');
        $user->role         ='Administrateur';
        $user->email         = Session::get('email');
        $user->password      = bcrypt(Session::get('login_password'));
        $user->save();


        Session::put('email', '');
        Session::put('first_name', '');
        Session::put('last_name', '');
        Session::put('login_password', '');


        // $setting = Setting::where('title', 'application_name')->where('lang', 'en')->first();
        // $setting->value = $request->application_name;
        // $setting->save();

        $this->endWrite('APP_INSTALLED', 'yes');
         $this->endWrite('APP_URL', Session::get('weburl'));
         $this->endWrite('APP_DEBUG', 'false');
         $this->endWrite('APP_ENV', 'production');
       // $this->endWrite('ASSET_URL', Session::get('weburl'). '/public');

        return redirect('/');

    }

    public function install()
    {

        Session::put('step', 2);
        return redirect()->route('check_environment');

    }


    public function checkEnvironment()
    {
        if(Session::get('step') == 1 || Session::get('step') == ""){

            return redirect()->route('install');

        }elseif(Session::get('step') == 3) {

            return redirect()->route('purchase_code_database');

        }elseif(Session::get('step') == 4) {

            return redirect()->route('system-setup-info');
        }

        $directories = array(
            "/routes",
            "/resources",
            "/public",
            "/storage",
            "/.env",
        );
        $error_count = 0;

        return view('installer::check_environment_database_page', compact('directories', 'error_count'));
    }

    public function checkEnvironmentPost(Request $request)
    {
        try {
            if (phpversion() >= '7.2' && OPENSSL_VERSION_NUMBER > 0x009080bf && extension_loaded('mbstring') && extension_loaded('tokenizer') && extension_loaded('xml') && extension_loaded('ctype')  && extension_loaded('json') && extension_loaded('bcmath') && extension_loaded('ctype') && extension_loaded('fileinfo')) {
                Session::put('step', 3);
                return redirect()->route('purchase_code_database');
            } else {

                return redirect()->back()->with("message-danger", "Ops! Extension are disabled.  Please check requirements!");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("message-danger", "Ops! Something went wrong, please try again!");
        }
    }

    public function purchaseCodeVerification()
    {
        if(Session::get('step') == 1 || Session::get('step') == ""){

            return redirect()->route('install');

        }elseif(Session::get('step') == 2){

            return redirect()->route('check_environment');

        }elseif(Session::get('step') == 4) {

            return redirect()->route('system-setup-info');
        }


        return view('installer::purchase_code_verification');
    }

    public function purchaseCodeVerificationPost(Request $request)
    {
        $request->validate([
            'envatoUser' => 'required',
            'purchaseCode' => 'required',
            'databaseName' => 'required',
            'databaseUsername' => 'required',
        ]);

        try {

            $envatouser = htmlspecialchars($request->input('envatoUser'));
            $purchasecode = htmlspecialchars($request->input('purchaseCode'));
            $UserData = Envato::verifyPurchase($purchasecode);

            if (!empty($UserData['verify-purchase']['item_id'])) {

                $this->endWrite('DB_DATABASE', $request->databaseName);
                $this->endWrite('DB_USERNAME', $request->databaseUsername);
                $this->endWrite('DB_PASSWORD', $request->databasePassword);

                Session::put('step', 4);

                return redirect()->route('system-setup-info');

            } else {

                return redirect()->back()->with("message-danger", "Ops! Purchase Code is not valid. Please try again.");
            }

        } catch (\Exception $e) {
            return redirect()->back()->with("message-danger", "Ops! Something went wrong, please try again!");
        }
    }

    function valid_purchase_code($purchase_code =''){
        return 'verified';
        $purchase_code = urlencode($purchase_code);
        $verified  = "unverified";
        if(!empty($purchase_code) && $purchase_code !='' && $purchase_code !=NULL && strlen($purchase_code) > 24):
            $url = 'https://api.envato.com/v3/market/author/sale?code='.$purchase_code;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Envato API Wrapper PHP)');

            $header = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json';
            $header[] = 'Authorization: Bearer 5CZXrrM34RPf7ukUzCKqod2BAcQJNKE6';

            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $data = curl_exec($ch);
            curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
            if( !empty($data) ):
                $result = json_decode($data,true);
                if(isset($result['buyer']) && isset($result['item']['id'])):
                    $verified  = "verified";
                endif;
            endif;
        endif;
        return $verified;
    }

    private function endWrite($key, $value){
        $env = file_get_contents(isset($env_path) ? $env_path : base_path('.env')); //fet .env file
        $env = str_replace("$key=" . env($key), "$key=", $env); //replace value

        $value = preg_replace('/\s+/', '', $value); //replace special ch
        $key = strtoupper($key); //force upper for security
        $env = file_get_contents(isset($env_path) ? $env_path : base_path('.env')); //fet .env file
        $env = str_replace("$key=" . env($key), "$key=" . $value, $env); //replace value
        /** Save file eith new content */
        $env = file_put_contents(isset($env_path) ? $env_path : base_path('.env'), $env);
        return true;
    }


    public function systemSetupInfo()
    {
        if(Session::get('step') == 1 || Session::get('step') == ""){

            return redirect()->route('install');

        }elseif(Session::get('step') == 2){

            return redirect()->route('check_environment');

        }elseif(Session::get('step') == 3) {

            return redirect()->route('purchase_code_database');
        }

        return view('installer::system_setup_page');
    }

    public function confirmInstalling(Request $request)
    {
        $request->validate([
            'system_admin_email' => 'required',
            'application_name' => 'required',
            'system_admin_password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);


        try {

            set_time_limit(2700);

            \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            foreach(\DB::select('SHOW TABLES') as $table) {
                $table_array = get_object_vars($table);
                \Schema::drop($table_array[key($table_array)]);
            }

            \Artisan::call('migrate:refresh');
            

            // $sql = base_path('database/db_test.sql');
            // DB::unprepared(file_get_contents($sql));

            $user = User::find(1);
            $user->email = $request->system_admin_email;
            $user->password = bcrypt($request->system_admin_password);
            $user->save();


          

            Session::put('step', '');
            $this->endWrite('APP_INSTALLED', 'yes');
            return redirect('/');

        } catch (\Exception $e) {
            return redirect()->back()->with("message-danger", "Ops! Something went wrong, please try again!");
        }


    }

    public function systemAdminCreate()
    {
        

        return redirect('/');
    }
}
