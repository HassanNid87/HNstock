<?php

namespace App\Repository;

use App\Data\ClientFilterData;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClientsRepository
{

    protected const PER_PAGE = 10;

    public function __construct(
        protected readonly Client $model,
    )
    {
    }

    public function fetch(ClientFilterData $filter): LengthAwarePaginator
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

        $results = $query->withCount(['payments', 'sales'])->paginate(self::PER_PAGE);

        return $this->mapClients($results);
    }

    public function isDeletable(Client $client): bool
    {
        return $client->sales_count < 1 && $client->payments_count < 1;
    }


    protected function mapClients(LengthAwarePaginator $results): LengthAwarePaginator
    {
        return $results->through(function (Client $item) {
            $item->is_deletable = $this->isDeletable($item);
            return $item;
        });
    }


}
