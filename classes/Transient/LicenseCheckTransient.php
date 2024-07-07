<?php

namespace ACP\Transient;

use AC\Expirable;
use AC\Storage;

class LicenseCheckTransient implements Expirable
{

    private const CACHE_KEY = 'acp_periodic_license_check';

    /**
     * @var Storage\Timestamp
     */
    protected $timestamp;

    public function __construct(bool $network_only)
    {
        $factory = $network_only
            ? new Storage\NetworkOptionFactory()
            : new Storage\OptionFactory();

        $this->timestamp = new Storage\Timestamp(
            $factory->create(self::CACHE_KEY)
        );
    }

    public function is_expired(int $value = null): bool
    {
        return $this->timestamp->is_expired($value);
    }

    public function delete()
    {
        $this->timestamp->delete();
    }

    public function save(int $expiration_seconds): bool
    {
        // Always store timestamp before option data.
        return $this->timestamp->save(time() + $expiration_seconds);
    }

}