<?php

$items = [
    [
        'name' => 'Шорты',
        'count' => 1,
        'price' => 1000,
    ],
    [
        'name' => 'Платье',
        'count' => 1,
        'price' => 1000,
    ],
    [
        'name' => 'Юбка',
        'count' => 1,
        'price' => 1000,
    ]
];

function calculationDiscountByPercentage(array $items, float $percent): array
{
    foreach ($items as $key => $item) {
        $items[$key]['discount'] = (float)$item['price'] * (float)$item['count'] * $percent;
    }
    return $items;
}

function calculationDiscountBySum(array $items, float $sum): array
{
    $itemsSum = 0;
    foreach ($items as $item) {
        $itemsSum += (float)$item['price'] * (float)$item['count'];
    }
    $percent = ($sum / $itemsSum) * 100;

    return calculationDiscountByPercentage($items, $percent);
}