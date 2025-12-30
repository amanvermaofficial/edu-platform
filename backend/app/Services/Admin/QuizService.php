<?php

namespace App\Services\Admin;

use App\Models\Quiz;
use App\Repositories\Admin\QuizRepository as AdminQuizRepository;
use Arr;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class QuizService.
 */
class QuizService
{
     protected $repo;

     public function __construct(AdminQuizRepository $repo)
     {
        $this->repo = $repo;
     }

     public function list(){
        return $this->repo->getAll();
     }

     public function create(array $data){
        DB::beginTransaction();
        try {
            $quiz = $this->repo->create($data);

            if(!empty($data['course_trade_ids'])){
                $this->repo->syncCourseTrades($quiz,$data['course_trade_ids']);
            }

           
 
            DB::commit();
            return $quiz;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
     }

     public function update(Quiz $quiz,array $data){
        DB::beginTransaction();
        try{
             $this->repo->update($quiz, $data);

             if(isset($data['course_trade_ids'])){
                $this->repo->syncCourseTrades($quiz, $data['course_trade_ids']);
             }

            DB::commit();
            return $quiz;
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
     }

    public function delete(Quiz $quiz)
    {
        return $this->repo->delete($quiz);
    }
}
