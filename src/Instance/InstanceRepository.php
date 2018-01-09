<?php namespace Pardot\PardotapiModule\Instance;

use Pardot\PardotapiModule\Instance\Contract\InstanceRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class InstanceRepository extends EntryRepository implements InstanceRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var InstanceModel
     */
    protected $model;

    /**
     * Create a new InstanceRepository instance.
     *
     * @param InstanceModel $model
     */
    public function __construct(InstanceModel $model)
    {
        $this->model = $model;
    }
}
