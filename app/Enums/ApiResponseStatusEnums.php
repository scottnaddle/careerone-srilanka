<?php

namespace App\Enums;

enum ApiResponseStatusEnums: string {
    // Success (2xx)
    case OK = '200';
    case CREATED = '201';
    case ACCEPTED = '202';
    case NO_CONTENT = '204';
    case FOUND = '302';

    // Client Error (4xx)
    case BAD_REQUEST = '400';
    case UNAUTHORIZED = '401';
    case FORBIDDEN = '403';
    case NOT_FOUND = '404';
    case METHOD_NOT_ALLOWED = '405';
    case CONFLICT = '409';
    case INTERNAL_SERVER_ERROR = '500';
    case BAD_GATEWAY = '502';
    case GATEWAY_TIMEOUT = '504';
}
