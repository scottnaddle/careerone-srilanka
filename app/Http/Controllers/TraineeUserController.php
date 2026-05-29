<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Resume;
use App\Models\TraineeTrainingHistory;
use App\Models\TraineeUser;
use Illuminate\Http\Request;

class TraineeUserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $traineeUser = TraineeUser::where('id', $id)->first();
        $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $id)->first();
        $traineeResume = Resume::where('trainee_id', $id)->get();
        $traineePortfolio = Portfolio::where('trainee_id', $id)->first();
        $traineeUser->sumary_training = getSumaryTraining($traineeUser->id);
        $traineeBasicInformation = array();
        if ($traineeTrainingInformations) {
            $trainingInformations = json_decode($traineeTrainingInformations->content);
            $trainingCertificates = $traineeTrainingInformations->nvq_content != null ? json_decode($traineeTrainingInformations->nvq_content) : null;

            foreach ($trainingInformations as $key => $trainingInformation) {
                $traineeBasicInformation[$key]['certificate'] = $trainingInformation->NVQ_QUALIFICATION;
                $traineeBasicInformation[$key]['education'] = $trainingInformation->COURSE;
                $traineeBasicInformation[$key]['institute'] = $trainingInformation->INSTITUTE;
            }
            return response()->json([
                'trainee_user' => $traineeUser,
                'trainee_information' => $traineeBasicInformation,
                'trainee_certificates' => $trainingCertificates,
                'trainee_resume' => $traineeResume,
                'trainee_portfolio' => $traineePortfolio ? route('trainee.career-guidance.portfolio.preview-portfolio', ['pid'=>$traineePortfolio->id]) : '',
                'trainee_portfolio_public' => $traineeUser->public_portfolio,
            ]);
        } else {
            return response()->json([
                'trainee_user' => $traineeUser,
                'trainee_information' => null,
                'trainee_certificates' => null,
                'trainee_resume' => $traineeResume,
                'trainee_portfolio' => $traineePortfolio ? route('trainee.career-guidance.portfolio.preview-portfolio', ['pid'=>$traineePortfolio->id]) : '',
                'trainee_portfolio_public' => $traineeUser->public_portfolio,
            ]);
        }


    }

}
