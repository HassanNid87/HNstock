<?php

namespace App\Repository;

use App\Data\ClientFilterData;
use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientsRepository
{

    protected const PER_PAGE = 10;
    protected Client $model;

    public function __construct()
    {
        $this->model = app(Client::class);
    }

    public function fetch(ClientFilterData $filter)
    {
        $query = $this->model::query();

        if ($filter->hasCode()) {
            $code = $filter->getCode();
            $query->where(function ($query) use ($code) {
                $query->where('name', 'like', "%{$code}%")
                    ->orWhere('adresse', 'like', "%{$code}%")
                    ->orWhere('code', 'like', "%{$code}%");
            });
        }

        if ($filter->hasMinSold()) {
            $query->where('solde', '>=', $filter->getMinSold());
        }


        if ($filter->hasMaxSold()) {
            $query->where('solde', '<=', $filter->getMaxSold());
        }

        return $query->paginate(self::PER_PAGE);
    }





}
