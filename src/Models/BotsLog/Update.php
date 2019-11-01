<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\BotsLog;


class Update extends AbstractBotsLog
{
    /** @var string  */
    private $uid = '';

    /** @var string  */
    private $status = '';

    /**
     * @param string $uid
     */
    public function setUID(string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => 'slate_addon_logs',
            'id' => $this->uid,
            'attributes' => [
                'status' => $this->status,
                'run_once' => 'PASSED',
                'condition' => 'PASSED',
                'response_body' => [

                ]
            ]
        ];
    }
}
