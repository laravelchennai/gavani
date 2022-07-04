<?php

namespace App\Observers;

use App\Jobs\Checks\SslCheckerJob;
use App\Models\Monitoring\Site;

class SiteObserver
{
    /**
     * Handle the Site "created" event.
     *
     * @param  \App\Models\Monitoring\Site  $site
     * @return void
     */
    public function created(Site $site)
    {
        SslCheckerJob::dispatch($site);
    }
}
