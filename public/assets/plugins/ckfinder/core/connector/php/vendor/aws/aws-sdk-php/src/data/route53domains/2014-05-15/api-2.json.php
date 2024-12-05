<?php
// This file was auto-generated from sdk-root/src/data/route53domains/2014-05-15/api-2.json
return [
    'version' => '2.0',
    'metadata' => [
        'apiVersion' => '2014-05-15',
        'endpointPrefix' => 'route53domains',
        'jsonVersion' => '1.1',
        'protocol' => 'json',
        'serviceFullName' => 'Amazon Route 53 Domains',
        'signatureVersion' => 'v4',
        'targetPrefix' => 'Route53Domains_v20140515',
        'uid' => 'route53domains-2014-05-15',
    ],
    'operations' => [
        'CheckDomainAvailability' => [
            'name' => 'CheckDomainAvailability',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CheckDomainAvailabilityRequest',],
            'output' => ['shape' => 'CheckDomainAvailabilityResponse',],
            'errors' => [['shape' => 'InvalidInput',], ['shape' => 'UnsupportedTLD',],],
        ],
        'DeleteTagsForDomain' => [
            'name' => 'DeleteTagsForDomain',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteTagsForDomainRequest',],
            'output' => ['shape' => 'DeleteTagsForDomainResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'DisableDomainAutoRenew' => [
            'name' => 'DisableDomainAutoRenew',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisableDomainAutoRenewRequest',],
            'output' => ['shape' => 'DisableDomainAutoRenewResponse',],
            'errors' => [['shape' => 'InvalidInput',], ['shape' => 'UnsupportedTLD',],],
        ],
        'DisableDomainTransferLock' => [
            'name' => 'DisableDomainTransferLock',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisableDomainTransferLockRequest',],
            'output' => ['shape' => 'DisableDomainTransferLockResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'EnableDomainAutoRenew' => [
            'name' => 'EnableDomainAutoRenew',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'EnableDomainAutoRenewRequest',],
            'output' => ['shape' => 'EnableDomainAutoRenewResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'UnsupportedTLD',],
                ['shape' => 'TLDRulesViolation',],
            ],
        ],
        'EnableDomainTransferLock' => [
            'name' => 'EnableDomainTransferLock',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'EnableDomainTransferLockRequest',],
            'output' => ['shape' => 'EnableDomainTransferLockResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'GetContactReachabilityStatus' => [
            'name' => 'GetContactReachabilityStatus',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetContactReachabilityStatusRequest',],
            'output' => ['shape' => 'GetContactReachabilityStatusResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'GetDomainDetail' => [
            'name' => 'GetDomainDetail',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetDomainDetailRequest',],
            'output' => ['shape' => 'GetDomainDetailResponse',],
            'errors' => [['shape' => 'InvalidInput',], ['shape' => 'UnsupportedTLD',],],
        ],
        'GetDomainSuggestions' => [
            'name' => 'GetDomainSuggestions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetDomainSuggestionsRequest',],
            'output' => ['shape' => 'GetDomainSuggestionsResponse',],
            'errors' => [['shape' => 'InvalidInput',], ['shape' => 'UnsupportedTLD',],],
        ],
        'GetOperationDetail' => [
            'name' => 'GetOperationDetail',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetOperationDetailRequest',],
            'output' => ['shape' => 'GetOperationDetailResponse',],
            'errors' => [['shape' => 'InvalidInput',],],
        ],
        'ListDomains' => [
            'name' => 'ListDomains',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ListDomainsRequest',],
            'output' => ['shape' => 'ListDomainsResponse',],
            'errors' => [['shape' => 'InvalidInput',],],
        ],
        'ListOperations' => [
            'name' => 'ListOperations',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ListOperationsRequest',],
            'output' => ['shape' => 'ListOperationsResponse',],
            'errors' => [['shape' => 'InvalidInput',],],
        ],
        'ListTagsForDomain' => [
            'name' => 'ListTagsForDomain',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ListTagsForDomainRequest',],
            'output' => ['shape' => 'ListTagsForDomainResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'RegisterDomain' => [
            'name' => 'RegisterDomain',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RegisterDomainRequest',],
            'output' => ['shape' => 'RegisterDomainResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'UnsupportedTLD',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'DomainLimitExceeded',],
                ['shape' => 'OperationLimitExceeded',],
            ],
        ],
        'RenewDomain' => [
            'name' => 'RenewDomain',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RenewDomainRequest',],
            'output' => ['shape' => 'RenewDomainResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'UnsupportedTLD',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'OperationLimitExceeded',],
            ],
        ],
        'ResendContactReachabilityEmail' => [
            'name' => 'ResendContactReachabilityEmail',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ResendContactReachabilityEmailRequest',],
            'output' => ['shape' => 'ResendContactReachabilityEmailResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'RetrieveDomainAuthCode' => [
            'name' => 'RetrieveDomainAuthCode',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RetrieveDomainAuthCodeRequest',],
            'output' => ['shape' => 'RetrieveDomainAuthCodeResponse',],
            'errors' => [['shape' => 'InvalidInput',], ['shape' => 'UnsupportedTLD',],],
        ],
        'TransferDomain' => [
            'name' => 'TransferDomain',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'TransferDomainRequest',],
            'output' => ['shape' => 'TransferDomainResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'UnsupportedTLD',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'DomainLimitExceeded',],
                ['shape' => 'OperationLimitExceeded',],
            ],
        ],
        'UpdateDomainContact' => [
            'name' => 'UpdateDomainContact',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UpdateDomainContactRequest',],
            'output' => ['shape' => 'UpdateDomainContactResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'UpdateDomainContactPrivacy' => [
            'name' => 'UpdateDomainContactPrivacy',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UpdateDomainContactPrivacyRequest',],
            'output' => ['shape' => 'UpdateDomainContactPrivacyResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'UpdateDomainNameservers' => [
            'name' => 'UpdateDomainNameservers',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UpdateDomainNameserversRequest',],
            'output' => ['shape' => 'UpdateDomainNameserversResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'DuplicateRequest',],
                ['shape' => 'TLDRulesViolation',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'UpdateTagsForDomain' => [
            'name' => 'UpdateTagsForDomain',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UpdateTagsForDomainRequest',],
            'output' => ['shape' => 'UpdateTagsForDomainResponse',],
            'errors' => [
                ['shape' => 'InvalidInput',],
                ['shape' => 'OperationLimitExceeded',],
                ['shape' => 'UnsupportedTLD',],
            ],
        ],
        'ViewBilling' => [
            'name' => 'ViewBilling',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ViewBillingRequest',],
            'output' => ['shape' => 'ViewBillingResponse',],
            'errors' => [['shape' => 'InvalidInput',],],
        ],
    ],
    'shapes' => [
        'AddressLine' => ['type' => 'string', 'max' => 255,],
        'BillingRecord' => [
            'type' => 'structure',
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'Operation' => ['shape' => 'OperationType',],
                'InvoiceId' => ['shape' => 'InvoiceId',],
                'BillDate' => ['shape' => 'Timestamp',],
                'Price' => ['shape' => 'Price',],
            ],
        ],
        'BillingRecords' => ['type' => 'list', 'member' => ['shape' => 'BillingRecord',],],
        'Boolean' => ['type' => 'boolean',],
        'CheckDomainAvailabilityRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',], 'IdnLangCode' => ['shape' => 'LangCode',],],
        ],
        'CheckDomainAvailabilityResponse' => [
            'type' => 'structure',
            'required' => ['Availability',],
            'members' => ['Availability' => ['shape' => 'DomainAvailability',],],
        ],
        'City' => ['type' => 'string', 'max' => 255,],
        'ContactDetail' => [
            'type' => 'structure',
            'members' => [
                'FirstName' => ['shape' => 'ContactName',],
                'LastName' => ['shape' => 'ContactName',],
                'ContactType' => ['shape' => 'ContactType',],
                'OrganizationName' => ['shape' => 'ContactName',],
                'AddressLine1' => ['shape' => 'AddressLine',],
                'AddressLine2' => ['shape' => 'AddressLine',],
                'City' => ['shape' => 'City',],
                'State' => ['shape' => 'State',],
                'CountryCode' => ['shape' => 'CountryCode',],
                'ZipCode' => ['shape' => 'ZipCode',],
                'PhoneNumber' => ['shape' => 'ContactNumber',],
                'Email' => ['shape' => 'Email',],
                'Fax' => ['shape' => 'ContactNumber',],
                'ExtraParams' => ['shape' => 'ExtraParamList',],
            ],
            'sensitive' => true,
        ],
        'ContactName' => ['type' => 'string', 'max' => 255,],
        'ContactNumber' => ['type' => 'string', 'max' => 30,],
        'ContactType' => [
            'type' => 'string',
            'enum' => ['PERSON', 'COMPANY', 'ASSOCIATION', 'PUBLIC_BODY', 'RESELLER',],
        ],
        'CountryCode' => [
            'type' => 'string',
            'enum' => [
                'AD',
                'AE',
                'AF',
                'AG',
                'AI',
                'AL',
                'AM',
                'AN',
                'AO',
                'AQ',
                'AR',
                'AS',
                'AT',
                'AU',
                'AW',
                'AZ',
                'BA',
                'BB',
                'BD',
                'BE',
                'BF',
                'BG',
                'BH',
                'BI',
                'BJ',
                'BL',
                'BM',
                'BN',
                'BO',
                'BR',
                'BS',
                'BT',
                'BW',
                'BY',
                'BZ',
                'CA',
                'CC',
                'CD',
                'CF',
                'CG',
                'CH',
                'CI',
                'CK',
                'CL',
                'CM',
                'CN',
                'CO',
                'CR',
                'CU',
                'CV',
                'CX',
                'CY',
                'CZ',
                'DE',
                'DJ',
                'DK',
                'DM',
                'DO',
                'DZ',
                'EC',
                'EE',
                'EG',
                'ER',
                'ES',
                'ET',
                'FI',
                'FJ',
                'FK',
                'FM',
                'FO',
                'FR',
                'GA',
                'GB',
                'GD',
                'GE',
                'GH',
                'GI',
                'GL',
                'GM',
                'GN',
                'GQ',
                'GR',
                'GT',
                'GU',
                'GW',
                'GY',
                'HK',
                'HN',
                'HR',
                'HT',
                'HU',
                'ID',
                'IE',
                'IL',
                'IM',
                'IN',
                'IQ',
                'IR',
                'IS',
                'IT',
                'JM',
                'JO',
                'JP',
                'KE',
                'KG',
                'KH',
                'KI',
                'KM',
                'KN',
                'KP',
                'KR',
                'KW',
                'KY',
                'KZ',
                'LA',
                'LB',
                'LC',
                'LI',
                'LK',
                'LR',
                'LS',
                'LT',
                'LU',
                'LV',
                'LY',
                'MA',
                'MC',
                'MD',
                'ME',
                'MF',
                'MG',
                'MH',
                'MK',
                'ML',
                'MM',
                'MN',
                'MO',
                'MP',
                'MR',
                'MS',
                'MT',
                'MU',
                'MV',
                'MW',
                'MX',
                'MY',
                'MZ',
                'NA',
                'NC',
                'NE',
                'NG',
                'NI',
                'NL',
                'NO',
                'NP',
                'NR',
                'NU',
                'NZ',
                'OM',
                'PA',
                'PE',
                'PF',
                'PG',
                'PH',
                'PK',
                'PL',
                'PM',
                'PN',
                'PR',
                'PT',
                'PW',
                'PY',
                'QA',
                'RO',
                'RS',
                'RU',
                'RW',
                'SA',
                'SB',
                'SC',
                'SD',
                'SE',
                'SG',
                'SH',
                'SI',
                'SK',
                'SL',
                'SM',
                'SN',
                'SO',
                'SR',
                'ST',
                'SV',
                'SY',
                'SZ',
                'TC',
                'TD',
                'TG',
                'TH',
                'TJ',
                'TK',
                'TL',
                'TM',
                'TN',
                'TO',
                'TR',
                'TT',
                'TV',
                'TW',
                'TZ',
                'UA',
                'UG',
                'US',
                'UY',
                'UZ',
                'VA',
                'VC',
                'VE',
                'VG',
                'VI',
                'VN',
                'VU',
                'WF',
                'WS',
                'YE',
                'YT',
                'ZA',
                'ZM',
                'ZW',
            ],
        ],
        'CurrentExpiryYear' => ['type' => 'integer',],
        'DNSSec' => ['type' => 'string',],
        'DeleteTagsForDomainRequest' => [
            'type' => 'structure',
            'required' => ['DomainName', 'TagsToDelete',],
            'members' => ['DomainName' => ['shape' => 'DomainName',], 'TagsToDelete' => ['shape' => 'TagKeyList',],],
        ],
        'DeleteTagsForDomainResponse' => ['type' => 'structure', 'members' => [],],
        'DisableDomainAutoRenewRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'DisableDomainAutoRenewResponse' => ['type' => 'structure', 'members' => [],],
        'DisableDomainTransferLockRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'DisableDomainTransferLockResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'DomainAuthCode' => ['type' => 'string', 'max' => 1024, 'sensitive' => true,],
        'DomainAvailability' => [
            'type' => 'string',
            'enum' => [
                'AVAILABLE',
                'AVAILABLE_RESERVED',
                'AVAILABLE_PREORDER',
                'UNAVAILABLE',
                'UNAVAILABLE_PREMIUM',
                'UNAVAILABLE_RESTRICTED',
                'RESERVED',
                'DONT_KNOW',
            ],
        ],
        'DomainLimitExceeded' => [
            'type' => 'structure',
            'members' => ['message' => ['shape' => 'ErrorMessage',],],
            'exception' => true,
        ],
        'DomainName' => ['type' => 'string', 'max' => 255, 'pattern' => '[a-zA-Z0-9_\\-.]*',],
        'DomainStatus' => ['type' => 'string',],
        'DomainStatusList' => ['type' => 'list', 'member' => ['shape' => 'DomainStatus',],],
        'DomainSuggestion' => [
            'type' => 'structure',
            'members' => ['DomainName' => ['shape' => 'DomainName',], 'Availability' => ['shape' => 'String',],],
        ],
        'DomainSuggestionsList' => ['type' => 'list', 'member' => ['shape' => 'DomainSuggestion',],],
        'DomainSummary' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'AutoRenew' => ['shape' => 'Boolean',],
                'TransferLock' => ['shape' => 'Boolean',],
                'Expiry' => ['shape' => 'Timestamp',],
            ],
        ],
        'DomainSummaryList' => ['type' => 'list', 'member' => ['shape' => 'DomainSummary',],],
        'DuplicateRequest' => [
            'type' => 'structure',
            'members' => ['message' => ['shape' => 'ErrorMessage',],],
            'exception' => true,
        ],
        'DurationInYears' => ['type' => 'integer', 'max' => 10, 'min' => 1,],
        'Email' => ['type' => 'string', 'max' => 254,],
        'EnableDomainAutoRenewRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'EnableDomainAutoRenewResponse' => ['type' => 'structure', 'members' => [],],
        'EnableDomainTransferLockRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'EnableDomainTransferLockResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'ErrorMessage' => ['type' => 'string',],
        'ExtraParam' => [
            'type' => 'structure',
            'required' => ['Name', 'Value',],
            'members' => ['Name' => ['shape' => 'ExtraParamName',], 'Value' => ['shape' => 'ExtraParamValue',],],
        ],
        'ExtraParamList' => ['type' => 'list', 'member' => ['shape' => 'ExtraParam',],],
        'ExtraParamName' => [
            'type' => 'string',
            'enum' => [
                'DUNS_NUMBER',
                'BRAND_NUMBER',
                'BIRTH_DEPARTMENT',
                'BIRTH_DATE_IN_YYYY_MM_DD',
                'BIRTH_COUNTRY',
                'BIRTH_CITY',
                'DOCUMENT_NUMBER',
                'AU_ID_NUMBER',
                'AU_ID_TYPE',
                'CA_LEGAL_TYPE',
                'CA_BUSINESS_ENTITY_TYPE',
                'ES_IDENTIFICATION',
                'ES_IDENTIFICATION_TYPE',
                'ES_LEGAL_FORM',
                'FI_BUSINESS_NUMBER',
                'FI_ID_NUMBER',
                'IT_PIN',
                'RU_PASSPORT_DATA',
                'SE_ID_NUMBER',
                'SG_ID_NUMBER',
                'VAT_NUMBER',
            ],
        ],
        'ExtraParamValue' => ['type' => 'string', 'max' => 2048,],
        'FIAuthKey' => ['type' => 'string',],
        'GetContactReachabilityStatusRequest' => [
            'type' => 'structure',
            'members' => ['domainName' => ['shape' => 'DomainName',],],
        ],
        'GetContactReachabilityStatusResponse' => [
            'type' => 'structure',
            'members' => ['domainName' => ['shape' => 'DomainName',], 'status' => ['shape' => 'ReachabilityStatus',],],
        ],
        'GetDomainDetailRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'GetDomainDetailResponse' => [
            'type' => 'structure',
            'required' => ['DomainName', 'Nameservers', 'AdminContact', 'RegistrantContact', 'TechContact',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'Nameservers' => ['shape' => 'NameserverList',],
                'AutoRenew' => ['shape' => 'Boolean',],
                'AdminContact' => ['shape' => 'ContactDetail',],
                'RegistrantContact' => ['shape' => 'ContactDetail',],
                'TechContact' => ['shape' => 'ContactDetail',],
                'AdminPrivacy' => ['shape' => 'Boolean',],
                'RegistrantPrivacy' => ['shape' => 'Boolean',],
                'TechPrivacy' => ['shape' => 'Boolean',],
                'RegistrarName' => ['shape' => 'RegistrarName',],
                'WhoIsServer' => ['shape' => 'RegistrarWhoIsServer',],
                'RegistrarUrl' => ['shape' => 'RegistrarUrl',],
                'AbuseContactEmail' => ['shape' => 'Email',],
                'AbuseContactPhone' => ['shape' => 'ContactNumber',],
                'RegistryDomainId' => ['shape' => 'RegistryDomainId',],
                'CreationDate' => ['shape' => 'Timestamp',],
                'UpdatedDate' => ['shape' => 'Timestamp',],
                'ExpirationDate' => ['shape' => 'Timestamp',],
                'Reseller' => ['shape' => 'Reseller',],
                'DnsSec' => ['shape' => 'DNSSec',],
                'StatusList' => ['shape' => 'DomainStatusList',],
            ],
        ],
        'GetDomainSuggestionsRequest' => [
            'type' => 'structure',
            'required' => ['DomainName', 'SuggestionCount', 'OnlyAvailable',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'SuggestionCount' => ['shape' => 'Integer',],
                'OnlyAvailable' => ['shape' => 'Boolean',],
            ],
        ],
        'GetDomainSuggestionsResponse' => [
            'type' => 'structure',
            'members' => ['SuggestionsList' => ['shape' => 'DomainSuggestionsList',],],
        ],
        'GetOperationDetailRequest' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'GetOperationDetailResponse' => [
            'type' => 'structure',
            'members' => [
                'OperationId' => ['shape' => 'OperationId',],
                'Status' => ['shape' => 'OperationStatus',],
                'Message' => ['shape' => 'ErrorMessage',],
                'DomainName' => ['shape' => 'DomainName',],
                'Type' => ['shape' => 'OperationType',],
                'SubmittedDate' => ['shape' => 'Timestamp',],
            ],
        ],
        'GlueIp' => ['type' => 'string', 'max' => 45,],
        'GlueIpList' => ['type' => 'list', 'member' => ['shape' => 'GlueIp',],],
        'HostName' => ['type' => 'string', 'max' => 255, 'pattern' => '[a-zA-Z0-9_\\-.]*',],
        'Integer' => ['type' => 'integer',],
        'InvalidInput' => [
            'type' => 'structure',
            'members' => ['message' => ['shape' => 'ErrorMessage',],],
            'exception' => true,
        ],
        'InvoiceId' => ['type' => 'string',],
        'LangCode' => ['type' => 'string', 'max' => 3,],
        'ListDomainsRequest' => [
            'type' => 'structure',
            'members' => ['Marker' => ['shape' => 'PageMarker',], 'MaxItems' => ['shape' => 'PageMaxItems',],],
        ],
        'ListDomainsResponse' => [
            'type' => 'structure',
            'required' => ['Domains',],
            'members' => [
                'Domains' => ['shape' => 'DomainSummaryList',],
                'NextPageMarker' => ['shape' => 'PageMarker',],
            ],
        ],
        'ListOperationsRequest' => [
            'type' => 'structure',
            'members' => ['Marker' => ['shape' => 'PageMarker',], 'MaxItems' => ['shape' => 'PageMaxItems',],],
        ],
        'ListOperationsResponse' => [
            'type' => 'structure',
            'required' => ['Operations',],
            'members' => [
                'Operations' => ['shape' => 'OperationSummaryList',],
                'NextPageMarker' => ['shape' => 'PageMarker',],
            ],
        ],
        'ListTagsForDomainRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'ListTagsForDomainResponse' => [
            'type' => 'structure',
            'required' => ['TagList',],
            'members' => ['TagList' => ['shape' => 'TagList',],],
        ],
        'Nameserver' => [
            'type' => 'structure',
            'required' => ['Name',],
            'members' => ['Name' => ['shape' => 'HostName',], 'GlueIps' => ['shape' => 'GlueIpList',],],
        ],
        'NameserverList' => ['type' => 'list', 'member' => ['shape' => 'Nameserver',],],
        'OperationId' => ['type' => 'string', 'max' => 255,],
        'OperationLimitExceeded' => [
            'type' => 'structure',
            'members' => ['message' => ['shape' => 'ErrorMessage',],],
            'exception' => true,
        ],
        'OperationStatus' => [
            'type' => 'string',
            'enum' => ['SUBMITTED', 'IN_PROGRESS', 'ERROR', 'SUCCESSFUL', 'FAILED',],
        ],
        'OperationSummary' => [
            'type' => 'structure',
            'required' => ['OperationId', 'Status', 'Type', 'SubmittedDate',],
            'members' => [
                'OperationId' => ['shape' => 'OperationId',],
                'Status' => ['shape' => 'OperationStatus',],
                'Type' => ['shape' => 'OperationType',],
                'SubmittedDate' => ['shape' => 'Timestamp',],
            ],
        ],
        'OperationSummaryList' => ['type' => 'list', 'member' => ['shape' => 'OperationSummary',],],
        'OperationType' => [
            'type' => 'string',
            'enum' => [
                'REGISTER_DOMAIN',
                'DELETE_DOMAIN',
                'TRANSFER_IN_DOMAIN',
                'UPDATE_DOMAIN_CONTACT',
                'UPDATE_NAMESERVER',
                'CHANGE_PRIVACY_PROTECTION',
                'DOMAIN_LOCK',
            ],
        ],
        'PageMarker' => ['type' => 'string', 'max' => 4096,],
        'PageMaxItems' => ['type' => 'integer', 'max' => 100,],
        'Price' => ['type' => 'double',],
        'ReachabilityStatus' => ['type' => 'string', 'enum' => ['PENDING', 'DONE', 'EXPIRED',],],
        'RegisterDomainRequest' => [
            'type' => 'structure',
            'required' => ['DomainName', 'DurationInYears', 'AdminContact', 'RegistrantContact', 'TechContact',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'IdnLangCode' => ['shape' => 'LangCode',],
                'DurationInYears' => ['shape' => 'DurationInYears',],
                'AutoRenew' => ['shape' => 'Boolean',],
                'AdminContact' => ['shape' => 'ContactDetail',],
                'RegistrantContact' => ['shape' => 'ContactDetail',],
                'TechContact' => ['shape' => 'ContactDetail',],
                'PrivacyProtectAdminContact' => ['shape' => 'Boolean',],
                'PrivacyProtectRegistrantContact' => ['shape' => 'Boolean',],
                'PrivacyProtectTechContact' => ['shape' => 'Boolean',],
            ],
        ],
        'RegisterDomainResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'RegistrarName' => ['type' => 'string',],
        'RegistrarUrl' => ['type' => 'string',],
        'RegistrarWhoIsServer' => ['type' => 'string',],
        'RegistryDomainId' => ['type' => 'string',],
        'RenewDomainRequest' => [
            'type' => 'structure',
            'required' => ['DomainName', 'CurrentExpiryYear',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'DurationInYears' => ['shape' => 'DurationInYears',],
                'CurrentExpiryYear' => ['shape' => 'CurrentExpiryYear',],
            ],
        ],
        'RenewDomainResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'Reseller' => ['type' => 'string',],
        'ResendContactReachabilityEmailRequest' => [
            'type' => 'structure',
            'members' => ['domainName' => ['shape' => 'DomainName',],],
        ],
        'ResendContactReachabilityEmailResponse' => [
            'type' => 'structure',
            'members' => [
                'domainName' => ['shape' => 'DomainName',],
                'emailAddress' => ['shape' => 'Email',],
                'isAlreadyVerified' => ['shape' => 'Boolean',],
            ],
        ],
        'RetrieveDomainAuthCodeRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',],],
        ],
        'RetrieveDomainAuthCodeResponse' => [
            'type' => 'structure',
            'required' => ['AuthCode',],
            'members' => ['AuthCode' => ['shape' => 'DomainAuthCode',],],
        ],
        'State' => ['type' => 'string', 'max' => 255,],
        'String' => ['type' => 'string',],
        'TLDRulesViolation' => [
            'type' => 'structure',
            'members' => ['message' => ['shape' => 'ErrorMessage',],],
            'exception' => true,
        ],
        'Tag' => [
            'type' => 'structure',
            'members' => ['Key' => ['shape' => 'TagKey',], 'Value' => ['shape' => 'TagValue',],],
        ],
        'TagKey' => ['type' => 'string',],
        'TagKeyList' => ['type' => 'list', 'member' => ['shape' => 'TagKey',],],
        'TagList' => ['type' => 'list', 'member' => ['shape' => 'Tag',],],
        'TagValue' => ['type' => 'string',],
        'Timestamp' => ['type' => 'timestamp',],
        'TransferDomainRequest' => [
            'type' => 'structure',
            'required' => ['DomainName', 'DurationInYears', 'AdminContact', 'RegistrantContact', 'TechContact',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'IdnLangCode' => ['shape' => 'LangCode',],
                'DurationInYears' => ['shape' => 'DurationInYears',],
                'Nameservers' => ['shape' => 'NameserverList',],
                'AuthCode' => ['shape' => 'DomainAuthCode',],
                'AutoRenew' => ['shape' => 'Boolean',],
                'AdminContact' => ['shape' => 'ContactDetail',],
                'RegistrantContact' => ['shape' => 'ContactDetail',],
                'TechContact' => ['shape' => 'ContactDetail',],
                'PrivacyProtectAdminContact' => ['shape' => 'Boolean',],
                'PrivacyProtectRegistrantContact' => ['shape' => 'Boolean',],
                'PrivacyProtectTechContact' => ['shape' => 'Boolean',],
            ],
        ],
        'TransferDomainResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'UnsupportedTLD' => [
            'type' => 'structure',
            'members' => ['message' => ['shape' => 'ErrorMessage',],],
            'exception' => true,
        ],
        'UpdateDomainContactPrivacyRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'AdminPrivacy' => ['shape' => 'Boolean',],
                'RegistrantPrivacy' => ['shape' => 'Boolean',],
                'TechPrivacy' => ['shape' => 'Boolean',],
            ],
        ],
        'UpdateDomainContactPrivacyResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'UpdateDomainContactRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'AdminContact' => ['shape' => 'ContactDetail',],
                'RegistrantContact' => ['shape' => 'ContactDetail',],
                'TechContact' => ['shape' => 'ContactDetail',],
            ],
        ],
        'UpdateDomainContactResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'UpdateDomainNameserversRequest' => [
            'type' => 'structure',
            'required' => ['DomainName', 'Nameservers',],
            'members' => [
                'DomainName' => ['shape' => 'DomainName',],
                'FIAuthKey' => ['shape' => 'FIAuthKey',],
                'Nameservers' => ['shape' => 'NameserverList',],
            ],
        ],
        'UpdateDomainNameserversResponse' => [
            'type' => 'structure',
            'required' => ['OperationId',],
            'members' => ['OperationId' => ['shape' => 'OperationId',],],
        ],
        'UpdateTagsForDomainRequest' => [
            'type' => 'structure',
            'required' => ['DomainName',],
            'members' => ['DomainName' => ['shape' => 'DomainName',], 'TagsToUpdate' => ['shape' => 'TagList',],],
        ],
        'UpdateTagsForDomainResponse' => ['type' => 'structure', 'members' => [],],
        'ViewBillingRequest' => [
            'type' => 'structure',
            'members' => [
                'Start' => ['shape' => 'Timestamp',],
                'End' => ['shape' => 'Timestamp',],
                'Marker' => ['shape' => 'PageMarker',],
                'MaxItems' => ['shape' => 'PageMaxItems',],
            ],
        ],
        'ViewBillingResponse' => [
            'type' => 'structure',
            'members' => [
                'NextPageMarker' => ['shape' => 'PageMarker',],
                'BillingRecords' => ['shape' => 'BillingRecords',],
            ],
        ],
        'ZipCode' => ['type' => 'string', 'max' => 255,],
    ],
];
