<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};


// Users

// id (Primary Key)
// name
// email
// password (hashed)
// created_at
// updated_at

// Quizzes

// id (Primary Key)
// title
// description
// created_at
// updated_at

// Questions

// id (Primary Key)
// quiz_id (Foreign Key to quizzes)
// question_text
// created_at
// updated_at
// Answers

// id (Primary Key)
// question_id (Foreign Key to questions)
// answer_text
// is_correct (Boolean to indicate if the answer is correct)
// created_at
// updated_at

// User_Responses

// id (Primary Key)
// user_id (Foreign Key to users)
// quiz_id (Foreign Key to quizzes)
// question_id (Foreign Key to questions)
// answer_id (Foreign Key to answers)
// created_at
// updated_at

// //////////////////////////////////////////////////

// Users

// id: Primary Key
// username: String, Unique
// email: String, Unique
// password: String
// created_at: Timestamp
// updated_at: Timestamp

// Quizzes

// id: Primary Key
// title: String
// description: Text
// created_by: Foreign Key (References Users.id)
// created_at: Timestamp
// updated_at: Timestamp

// Questions

// id: Primary Key
// quiz_id: Foreign Key (References Quizzes.id)
// question_text: Text
// created_at: Timestamp
// updated_at: Timestamp

// Answers

// id: Primary Key
// question_id: Foreign Key (References Questions.id)
// answer_text: Text
// is_correct: Boolean
// created_at: Timestamp
// updated_at: Timestamp

// User_Answers

// id: Primary Key
// user_id: Foreign Key (References Users.id)
// quiz_id: Foreign Key (References Quizzes.id)
// question_id: Foreign Key (References Questions.id)
// answer_id: Foreign Key (References Answers.id)
// created_at: Timestamp

// Results

// id: Primary Key
// user_id: Foreign Key (References Users.id)
// quiz_id: Foreign Key (References Quizzes.id)
// score: Integer
// created_at: Timestamp