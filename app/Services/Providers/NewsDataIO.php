<?php

namespace App\Services\Providers;

use App\Services\Abstractors\ProviderAbstractor;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use modules\Provider\Entities\Provider;
use modules\Source\Entities\Source;
use Illuminate\Support\Str;
use modules\Article\Entities\Article;
use modules\Author\Entities\Author;
use modules\Category\Entities\Category;
use modules\Country\Entities\Country;
use modules\Language\Entities\Language;

class NewsDataIO extends ProviderAbstractor {
}
