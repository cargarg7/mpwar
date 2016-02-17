<?php

namespace MPWAR\Module\Player\Domain;

use DateTimeImmutable;
use MPWAR\Module\Player\Contract\DomainEvent\PlayerRegistered;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

final class Player implements ContainsRecordedMessages
{
    private $id;
    private $name;
    private $registrationDate;

    use PrivateMessageRecorderCapabilities;

    public function __construct(PlayerId $id, PlayerName $name, DateTimeImmutable $registrationDate = null)
    {
        $this->id               = $id;
        $this->name             = $name;
        $this->registrationDate = $registrationDate ?: new DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function registrationDate()
    {
        return $this->registrationDate;
    }

    public static function register(PlayerId $id, PlayerName $name)
    {
        $player = new Player($id, $name);

        $player->record(new PlayerRegistered($id->value(), $player->registrationDate(), $name->value()));

        return $player;
    }
}
