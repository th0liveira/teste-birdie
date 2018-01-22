<?php
/**
 * Teste Birdie
 *
 * @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
use Config\Configuration;

return [
    /**
     * General Setting
     */
    Configuration::CONFIG_KEY_GENERAL   => [
        // Pagination Size
        Configuration::CONFIG_KEY_GENERAL_PAGINATION_SIZE => 10,
    ],

    /**
     * Mongo Settings
     */
    Configuration::CONFIG_KEY_MONGO     => [
        // Host
        Configuration::CONFIG_KEY_MONGO_HOST        => 'mongodb',
        // Port
        Configuration::CONFIG_KEY_MONGO_PORT        => 27017,
        // Db
        Configuration::CONFIG_KEY_MONGO_DB          => 'birdie',
        // Collection
        Configuration::CONFIG_KEY_MONGO_COLLECTION  => 'country',
    ],

    /**
     * rEDIS Settings
     */
    Configuration::CONFIG_KEY_REDIS     => [
        // Host
        Configuration::CONFIG_KEY_REDIS_HOST    => 'redis',
        // Port
        Configuration::CONFIG_KEY_REDIS_PORT    => 6379,
        // Db
        Configuration::CONFIG_KEY_REDIS_DB      => 1,
    ],
];
 