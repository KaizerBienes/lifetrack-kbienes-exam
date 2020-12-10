<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationHttpResponseException;
use App\Http\Controllers\Controller;
use App\Services\StudyTrackerService;
use App\Validations\CalculateEstimatesValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StudyTrackerController extends Controller {

    /**
     * Study Tracker Service
     *
     * @var App\Services\StudyTrackerService
     */
    protected $studyTrackerService;

    public function __construct(
        StudyTrackerService $studyTrackerService
    ) {
        $this->studyTrackerService = $studyTrackerService;
    }

    /**
     * @OA\Get(
     *     path="/v0/study-tracker/calculate",
     *     summary="Calculates the costs per month estimates",
     *     description="Calculates the costs per month estimate",
     *     tags={"Study Tracker"},
     *     @OA\Parameter(
     *         name="spd",
     *         in="query",
     *         description="Current Number of Study per Day",
     *         required=true,
     *         example="1",
     *         schema={
     *            "type"="integer"
     *         }
     *     ),
     *     @OA\Parameter(
     *         name="gpm",
     *         in="query",
     *         description="Study Growth Percentage per Month (%)",
     *         required=true,
     *         example="1",
     *         schema={
     *            "type"="integer"
     *         }
     *     ),
     *     @OA\Parameter(
     *         name="mtf",
     *         in="query",
     *         description="Months to Forecast",
     *         required=true,
     *         schema={
     *            "type"="integer"
     *         }
     *     ),
     *     @OA\Response(
     *         response=Symfony\Component\HttpFoundation\Response::HTTP_OK,
     *         description="Fetching Calculation Successful",
     *         @OA\JsonContent(
     *             example={
     *                 "data": {
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
     *         description="Invalid parameters.",
     *         @OA\JsonContent(
     *             example={
     *                 "error": {
     *                     "code": 422,
     *                     "message": "Invalid Parameters"
     *                 }
     *             }
     *         )
     *     )
     * )
     *
     * Get study tracker calculation
     *
     * @return Response
     */
    function calculateEstimates(Request $request) {
        return $this->controllerWrapper(function() use ($request) {
            try {
                $this->validate(
                    $request,
                    CalculateEstimatesValidator::getRules(),
                    CalculateEstimatesValidator::getMessages(),
                    CalculateEstimatesValidator::getAttributes()
                );
            } catch (ValidationException $e) {
                throw new ValidationHttpResponseException(
                    $e->getMessage(),
                    $e->status,
                    CalculateEstimatesValidator::constructResponse(
                        $e->errors(),
                        $e->status,
                        $e->getMessage()
                    )
                );
            }

            return response()->json([
                'data' => $this->studyTrackerService->calculateEstimates(
                    $request->get('spd'), // studies per day
                    $request->get('gpm'), // growth per month
                    $request->get('mtf'), // months to forecast
                )
            ]);
        });
    }
}