<?php

namespace App\Mail\Allocation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UnassignSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $tutor;
    public $students;

    public function __construct($student, $tutor)
    {
        $this->student = $student;
        $this->tutor = $tutor;
        $this->students = $student instanceof \Illuminate\Support\Collection ? $student : null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->students ? 'Students Unassigned Notification' : 'Tutor Unassignment Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->students ? 'emails.unassign-success-tutor' : 'emails.unassign-success-student',
        );
    }
}