<?php

declare(strict_types=1);

use Codewithkyrian\ChromaDB\Client;
use Codewithkyrian\ChromaDB\ChromaDB;
use Codewithkyrian\ChromaDB\Generated\Exceptions\ChromaAuthorizationException;

it('can connect to a normal chroma server', function () {
    $client = ChromaDB::client();

    expect($client)->toBeInstanceOf(Client::class);
});

it('can connect to a chroma server using factory', function () {
    $client = ChromaDB::factory()
        ->withHost('http://localhost')
        ->withPort(8000)
        ->connect();

    expect($client)->toBeInstanceOf(Client::class);
});

test('can connect to an API token authenticated chroma server', function () {
    $client = ChromaDB::factory()
        ->withPort(8001)
        ->withBearerToken('test-token')
        ->connect();

    expect($client)->toBeInstanceOf(Client::class);
});

it('cannot connect to an API token authenticated chroma server with wrong token', function () {
    ChromaDB::factory()
        ->withPort(8001)
        ->withBearerToken('wrong-token')
        ->connect();
})->throws(ChromaAuthorizationException::class);

it('throws exception when connecting to API token authenticated chroma server with no token', function () {
    ChromaDB::factory()
        ->withPort(8001)
        ->connect();
})->throws(ChromaAuthorizationException::class);
