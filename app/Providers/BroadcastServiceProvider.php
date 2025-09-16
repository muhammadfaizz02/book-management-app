<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // Only load channels.php if the file exists
    if (file_exists(base_path('routes/channels.php'))) {
      Broadcast::routes();
      require base_path('routes/channels.php');
    }
  }
}
