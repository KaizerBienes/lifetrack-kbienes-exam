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
     *     path="api/v0/study-tracker/calculate",
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
     *         example="1",
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
     *                     {
     *                         "month_year": "Dec 2020",
     *                         "studies_per_day": 1,
     *                         "total_studies": "31.00000000",
     *                         "cost_forecasted_in_usd": {
     *                             "ram_cost": "0.00205716",
     *                             "storage_cost": "0.00100000",
     *                             "total_cost": "0.00305716"
     *                         }
     *                     },
     *                     {
     *                         "month_year": "Jan 2021",
     *                         "studies_per_day": 1.01,
     *                         "total_studies": "31.31000000",
     *                         "cost_forecasted_in_usd": {
     *                             "ram_cost": "0.00207762",
     *                             "storage_cost": "0.00101000",
     *                             "total_cost": "0.00308762"
     *                         }
     *                     }
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
     *         description="Invalid parameters.",
     *         @OA\JsonContent(
     *             example={
     *                 {
     *                     "code": 422,
     *                     "message": "The given data was invalid.",
     *                     "errors": {
     *                         "spd": {
     *                           "The Number of study per day must be at least 1."
     *                         },
     *                         "gpm": {
     *                           "The Number of study growth per month (%) must be at least 0.01."
     *                         },
     *                         "mtf": {
     *                           "The Months to forecast must be at least 1."
     *                         }
     *                     }
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