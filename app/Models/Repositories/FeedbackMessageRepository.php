<?php

namespace App\Models\Repositories;

use App\Models\FeedbackMessage;
use Prettus\Validator\Contracts\ValidatorInterface;

class FeedbackMessageRepository extends BaseRepository {

    public function model() {
        return FeedbackMessage::class;
    }
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'nullable|numeric',
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500'],
        ValidatorInterface::RULE_UPDATE => [
            'user_id' => 'nullable|numeric',//not in
            'title' => 'sometimes|required|string|max:100',//not in
            'message' => 'sometimes|required|string|max:500']
    ];
    

}
