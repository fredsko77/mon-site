<?php
namespace App\Utils;

use DateTime;
use Faker\Factory;

trait FakerTrait
{

    /**
     * @param DateTime $originalDateTime
     *
     * @return bool|DateTime
     */
    public function setDateTimeAfter(DateTime $originalDateTime): bool | DateTime
    {
        $now = new DateTime();
        $interval = $now->diff($originalDateTime);
        $days = 0;

        if ($interval->y > 0) {
            $days += ($interval->y * 365);
        }
        if ($interval->m > 0) {
            $days += ($interval->m * 30);
        }
        if ($interval->d > 0) {
            $days += $interval->d;
        }

        return $originalDateTime->modify('+' . random_int(0, $days) . ' days');
    }

    /**
     * @param array|null $array
     *
     * @return string
     */
    public function setPageContent(?array $array = null): string
    {
        $faker = Factory::create('fr_FR');
        $sentences = is_array($array) ? $array : $faker->sentences(random_int(1, 4));
        $text = [];

        foreach ($sentences as $key => $sentence) {
            $text[$key] = '<p>' . $sentence . '</p>';
        }

        return join("\\n\\r", $text);
    }

    /**
     * @param array|null $array
     * @param int|null $limit
     *
     * @return array
     */
    public function selectRandomArrayElements(?array $array, ?int $limit = null): array
    {
        shuffle($array);
        $array_limit = $limit ?? count($array) - 1;
        return array_slice(
            $array,
            1,
            random_int(1, $array_limit)
        );
    }

}
