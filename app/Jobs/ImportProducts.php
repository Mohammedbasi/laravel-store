<?php

namespace App\Jobs;

use App\Models\Product;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProducts implements ShouldQueue
{
    protected $count;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // try {
        Product::factory($this->count)->create();
        // } catch (Exception $e) {
        // }
    }
}
