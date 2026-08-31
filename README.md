# PHP Habbo API Wrapper
A lightweight, PSR-compliant PHP wrapper for the Habbo API.

## Installation
Install the package via Composer:
```bash
composer require wiredspast/habbo-api-wrapper-php
```

> **Note:** This library requires a PSR-18 HTTP client (such as Guzzle) and a PSR-17 HTTP factory. If your project doesn't already have one, install Guzzle:
> ```bash
> composer require guzzlehttp/guzzle
> ```

## Basic Usage

### Initializing the API Client

Import the primary API class and your desired hotel configuration:

```php
use Wiredspast\HabboApiWrapperPhp\HabboPublicAPI;
use Wiredspast\HabboApiWrapperPhp\Param\Hotel;

// Create an instance targeting the .COM hotel
$api = HabboPublicAPI::fromHotel(Hotel::COM);
```

### Accessing Standard Endpoints

Once instantiated, use the resource methods to query public data, for example:

```php
// Fetch achievements list
$achievements = $api->achievements()->all();

// Fetch room details by ID
$room = $api->rooms()->byId($roomId);
```

## Wired Variables Endpoints

To interact with WIRED variables, call the `variables()` method on your API instance with the room ID and your read/write keys:

```php
$varApi = $api->variables($roomId, $wiredReadKey, $wiredWriteKey);

// Access variable data for the specified room
$allVarNames = $varApi->listAll();
$userVarProfile = $varApi->user()->getProfileByUsername('WiredSpast');
```

## Error Handling

API requests throw custom exceptions on failure. Wrap your calls in a `try/catch` block:

```php
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Psr\Http\Client\ClientExceptionInterface;

try {
    $room = $api->rooms()->byId($roomId);
} catch (HabboApiException $e) {
    // Handle API-specific errors (e.g., 404 Not Found, 500 Server Error)
} catch (ClientExceptionInterface $e) {
    // Handle network or transport issues
}
```

## Supported Feature Overview

- **Public Endpoints**: 
  - Achievements
  - Badge owner count
  - Groups
  - Marketplace statistics
  - Ping
  - Rooms
  - Lists
  - Users
- **Variable Endpoints**: 
  - Read and manage permanent user variables
  - Read and manage permanent furni variables
  - Read and manage permanent global variables