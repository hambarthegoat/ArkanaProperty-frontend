<?php

namespace App\Exceptions;

/**
 * The stored API token is missing, expired or revoked (HTTP 401).
 */
class ApiUnauthenticatedException extends ApiException {}
