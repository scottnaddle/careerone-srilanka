<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\CasTicket;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use phpCAS;
use Illuminate\Support\Facades\Session;
class CasController extends Controller {
    public function __construct(TraineeTrainingSyncService $traineeSyncService)
    {
        $this->traineeSyncService = $traineeSyncService;
    }
    public function getLogin(Request $request) {
        //Firstly, Check trainee has logged in of CareerOne Platform or not
        if (!Auth::guard('trainee')->check()) {
            //This code will save current session, ticket when CAS login successfully local DB, in order to Single sign out
            if ($request->has('ticket')) {
                $ticket = new CasTicket();
                $ticket->ticket = $request->ticket;
                $ticket->session_id = Session::getId();
                $ticket->save();
            }
            //Check has logged in on CAS SSO
            if (!phpCAS::isAuthenticated()) {
                //Force user to login, after redirect to CAS and login successfully, CAS will send a ticket to login
                phpCAS::setServerLoginURL(app('cas.loginUrl'));
                phpCAS::forceAuthentication();

            }
            $cas_user = phpCAS::getAttributes(); //Get user information returned by CAS
            $user = TraineeUser::where('nic', $cas_user['nic'])->first(); //Find user in local DB
            if ($user) {
                //This code will save email of user with existing session in order to Single sign out.
                $ticket = CasTicket::where('session_id', Session::getId())->first();
                if ($ticket) {
                    $ticket->email = $user->email;
                    $ticket->save();
                }
            }
            if (!$user) { //If not found user, create new user with information CAS returned.
                //Create new user
                $user = new TraineeUser();
                $user->nic = $cas_user['nic'];
                $user->email = $cas_user['email'];
                $user->password = bcrypt('Tvec@2025');
                $user->mobile = $cas_user['mobile'];
                $user->full_name = $cas_user['full_name'];
                $user->email_verified_at = now();
                $user->active = true;
                $state = $user->save();
                if ($state) {
                    $this->traineeSyncService->syncTraineeTrainingInformation($user);
                }
            }
            //Login to CareerOne.
            if ($user && $user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'trainee';
                Auth::guard('trainee')->logout();
                if (\phpCAS::isAuthenticated()) {
                    \phpCAS::logoutWithRedirectService(route('get-reactive-account-request', ['token' => $token, 'u_type' => $u_type]));
                }
            }elseif($user && $user->email_verified_at == null){
                $token = base64_encode($user->email);
                Auth::guard('trainee')->logout();
                return redirect('/verfication/isnotverified/trainee' . '/' . $token);
            }else {
                Auth::guard('trainee')->loginUsingId($user->id);
            }

        }
        return redirect('/');
    }
    public function logout(Request $request) {
        Log::info("Logout request sent: ".json_encode(request()->all()));
        session()->invalidate();

        if ($request->has('logoutRequest')) {
            $xml = new \SimpleXMLElement($request->logoutRequest);
            // Register namespaces to access the elements properly
            $xml->registerXPathNamespace('saml', 'urn:oasis:names:tc:SAML:2.0:assertion');
            $xml->registerXPathNamespace('samlp', 'urn:oasis:names:tc:SAML:2.0:protocol');
            $nic = (string) $xml->xpath('//saml:NameID')[0];
            $ticket = (string) $xml->xpath('//samlp:SessionIndex')[0];
            $cas_ticket = CasTicket::where('email', $nic)->where('ticket', $ticket)->first();
            if ($cas_ticket != null) {
                $userToLogout = TraineeUser::where('nic', $nic)->first();
//                Auth::guard('trainee')->setUser($userToLogout);
//                Auth::guard('trainee')->logout();
                session()->invalidate();
                session()->regenerateToken();
                Session::getHandler()->destroy($userToLogout->getAuthIdentifier());
                Session::setId($cas_ticket->session_id);
                Session::flush();
                $cas_ticket->delete();
                return response(['logout successfull', 200]);
            }else {
                return response(['Already logout', 200]);
            }

        }
//        phpCAS::handleLogoutRequests(true);
//        phpCAS::logoutWithRedirectService(env('CAS_CLIENT_SERVICE'));
//        return redirect()->route('homepage');
    }
}
