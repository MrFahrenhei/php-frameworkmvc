<?php

namespace App\Controllers;
use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\ContactForm;

/**
 * Class SiteController
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Controllers
 */
class SiteController extends Controller
{
    /**
     * @return string
     */
    public function home(): string
    {
        $params = [
            'name' => "beraldo",
            'pipoca' => "eu gosto",
            'ola' => 'não deixa'
        ];
        return $this->render('home', $params);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function contact(Request $request, Response $response): string
    {
        $contact = new ContactForm();
        if($request->isPost()){
            $contact->loadData($request->getBody());
            if($contact->validate() && $contact->send()){
                Application::$app->session->setFlash('success', 'Thanks for contacting us!');
               $response->redirect('/');
            }
        }
        return $this->render('contact', ['model'=>$contact]);
    }
}