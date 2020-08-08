<?php
declare(strict_types=1);

function traditionalTestTime(int $numberOfTestPerson): int {
    return $numberOfTestPerson;
}

function numberOfGroup(int $numberOfTestPerson, int $numberOfPeopleInGroup): int {
    return (int) round($numberOfTestPerson/$numberOfPeopleInGroup);
}

function totalPeopleLastGroup(int $numberOfTestPerson, int $numberOfPeopleInGroup): int {
    return $numberOfTestPerson % $numberOfPeopleInGroup;
}

function newTestTotalTestTimeStep1(int $numberOfTestPerson, int $numberOfPeopleInGroup): int {
    return numberOfGroup($numberOfTestPerson, $numberOfPeopleInGroup);
}

function positiveTestProbabilityOfGroup(int $numberOfTestPerson, int $numberOfPeopleInGroup, float $avgPositiveTestRate): float {
    // P(n) = 1 - P(A1A2...An) = 1 - (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1))
    $negativeTestProbability = 1.0; // P(A1A2...An)
    for ($i=1; $i<=$numberOfPeopleInGroup; $i++) {
        $negativeTestProbability = $negativeTestProbability * (1 - $avgPositiveTestRate*$numberOfTestPerson/($numberOfTestPerson - $i +1));
    }
    return 1 - $negativeTestProbability;
}

function newTestTotalTestTimeStep2(int $numberOfTestPerson, int $numberOfPeopleInGroup, float $avgPositiveTestRate): int {
    // g(n) = P/n * n * P(n) = P*P(n)
    return (int) ($numberOfTestPerson * positiveTestProbabilityOfGroup($numberOfTestPerson, $numberOfPeopleInGroup, $avgPositiveTestRate));
}

function newTestTotalTestTime(int $numberOfTestPerson, int $numberOfPeopleInGroup, float $avgPositiveTestRate): int {
    return newTestTotalTestTimeStep1($numberOfTestPerson, $numberOfPeopleInGroup) + newTestTotalTestTimeStep2($numberOfTestPerson, $numberOfPeopleInGroup, $avgPositiveTestRate);
}

function main(int $numberOfTestPerson, float $avgPositiveTestRate, int $maxEffectiveNumberInGroup) {
    $traditionalTestTime = traditionalTestTime($numberOfTestPerson);
    printf("Traditional Test time: %d\n\n", $traditionalTestTime);
    $minNewTestTime = $traditionalTestTime;
    $bestNumberOfPeopleInGroup = -1;
    for ($numberOfPeopleInGroup=2; $numberOfPeopleInGroup<=$maxEffectiveNumberInGroup; $numberOfPeopleInGroup++) {
        $totalTestTime = newTestTotalTestTime($numberOfTestPerson, $numberOfPeopleInGroup, $avgPositiveTestRate);
        printf("New Test time with n=%d: %d\n", $numberOfPeopleInGroup, $totalTestTime);
        if ($minNewTestTime > $totalTestTime) {
            $minNewTestTime = $totalTestTime;
            $bestNumberOfPeopleInGroup = $numberOfPeopleInGroup;
        }
    }

    if ($minNewTestTime < $traditionalTestTime) {
        printf("\nNew Test Method is better with %d people in 1 group. 
For traditional method, we need %d times, but for new method we only need %d times, %.2f percentage of traditional one.\n",
            $bestNumberOfPeopleInGroup, $traditionalTestTime, $minNewTestTime, $minNewTestTime*100/$traditionalTestTime);
    } else {
        printf("Traditional method is still better!\n");
    }
}

$numberOfTestPerson = 72275;
$avgPositiveTestRate = 797/482456;
$maxEffectiveNumberInGroup = 50;
main($numberOfTestPerson, $avgPositiveTestRate, $maxEffectiveNumberInGroup);