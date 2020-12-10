<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *   title="Lifetrack Study Tracker API",
     *   version="0",
     *   @OA\Contact(
     *     email="kaizer.bienes@gmail.com",
     *     name="Kaizer Bienes"
     *   )
     * )
     */

     protected function controllerWrapper($callback) {
         try {
            return $callback();
         } catch (HttpResponseException $e) {
             return response()
                ->json(
                    json_decode($e->getResponse()->getContent()),
                    $e->getCode()
                );
         } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode())
                ->header('Content-Type', 'application/json');
         }
     }
}
