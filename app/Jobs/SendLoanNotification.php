<?php

namespace App\Jobs;

use App\Models\BookLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLoanNotification implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $loan;

  public function __construct(BookLoan $loan)
  {
    $this->loan = $loan;
  }

  public function handle()
  {
    // Log the notification instead of sending email for testing
    Log::info('Loan notification sent for book: ' . $this->loan->book->title .
      ' to user: ' . $this->loan->user->email);

    // In a real application, you would send an email:
    // Mail::to($this->loan->user->email)->send(new BookLoaned($this->loan));
  }
}
