<?php
// This file was auto-generated from sdk-root/src/data/greengrass/2017-06-07/api-2.json
return [
    'metadata' => [
        'apiVersion' => '2017-06-07',
        'endpointPrefix' => 'greengrass',
        'signingName' => 'greengrass',
        'serviceFullName' => 'AWS Greengrass',
        'protocol' => 'rest-json',
        'jsonVersion' => '1.1',
        'uid' => 'greengrass-2017-06-07',
        'signatureVersion' => 'v4',
    ],
    'operations' => [
        'AssociateRoleToGroup' => [
            'name' => 'AssociateRoleToGroup',
            'http' => ['method' => 'PUT', 'requestUri' => '/greengrass/groups/{GroupId}/role', 'responseCode' => 200,],
            'input' => ['shape' => 'AssociateRoleToGroupRequest',],
            'output' => ['shape' => 'AssociateRoleToGroupResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'AssociateServiceRoleToAccount' => [
            'name' => 'AssociateServiceRoleToAccount',
            'http' => ['method' => 'PUT', 'requestUri' => '/greengrass/servicerole', 'responseCode' => 200,],
            'input' => ['shape' => 'AssociateServiceRoleToAccountRequest',],
            'output' => ['shape' => 'AssociateServiceRoleToAccountResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'CreateCoreDefinition' => [
            'name' => 'CreateCoreDefinition',
            'http' => ['method' => 'POST', 'requestUri' => '/greengrass/definition/cores', 'responseCode' => 200,],
            'input' => ['shape' => 'CreateCoreDefinitionRequest',],
            'output' => ['shape' => 'CreateCoreDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateCoreDefinitionVersion' => [
            'name' => 'CreateCoreDefinitionVersion',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/definition/cores/{CoreDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateCoreDefinitionVersionRequest',],
            'output' => ['shape' => 'CreateCoreDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateDeployment' => [
            'name' => 'CreateDeployment',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/groups/{GroupId}/deployments',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateDeploymentRequest',],
            'output' => ['shape' => 'CreateDeploymentResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateDeviceDefinition' => [
            'name' => 'CreateDeviceDefinition',
            'http' => ['method' => 'POST', 'requestUri' => '/greengrass/definition/devices', 'responseCode' => 200,],
            'input' => ['shape' => 'CreateDeviceDefinitionRequest',],
            'output' => ['shape' => 'CreateDeviceDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateDeviceDefinitionVersion' => [
            'name' => 'CreateDeviceDefinitionVersion',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/definition/devices/{DeviceDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateDeviceDefinitionVersionRequest',],
            'output' => ['shape' => 'CreateDeviceDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateFunctionDefinition' => [
            'name' => 'CreateFunctionDefinition',
            'http' => ['method' => 'POST', 'requestUri' => '/greengrass/definition/functions', 'responseCode' => 200,],
            'input' => ['shape' => 'CreateFunctionDefinitionRequest',],
            'output' => ['shape' => 'CreateFunctionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateFunctionDefinitionVersion' => [
            'name' => 'CreateFunctionDefinitionVersion',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/definition/functions/{FunctionDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateFunctionDefinitionVersionRequest',],
            'output' => ['shape' => 'CreateFunctionDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateGroup' => [
            'name' => 'CreateGroup',
            'http' => ['method' => 'POST', 'requestUri' => '/greengrass/groups', 'responseCode' => 200,],
            'input' => ['shape' => 'CreateGroupRequest',],
            'output' => ['shape' => 'CreateGroupResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateGroupCertificateAuthority' => [
            'name' => 'CreateGroupCertificateAuthority',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/groups/{GroupId}/certificateauthorities',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateGroupCertificateAuthorityRequest',],
            'output' => ['shape' => 'CreateGroupCertificateAuthorityResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'CreateGroupVersion' => [
            'name' => 'CreateGroupVersion',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/groups/{GroupId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateGroupVersionRequest',],
            'output' => ['shape' => 'CreateGroupVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateLoggerDefinition' => [
            'name' => 'CreateLoggerDefinition',
            'http' => ['method' => 'POST', 'requestUri' => '/greengrass/definition/loggers', 'responseCode' => 200,],
            'input' => ['shape' => 'CreateLoggerDefinitionRequest',],
            'output' => ['shape' => 'CreateLoggerDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateLoggerDefinitionVersion' => [
            'name' => 'CreateLoggerDefinitionVersion',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/definition/loggers/{LoggerDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateLoggerDefinitionVersionRequest',],
            'output' => ['shape' => 'CreateLoggerDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateSubscriptionDefinition' => [
            'name' => 'CreateSubscriptionDefinition',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/definition/subscriptions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateSubscriptionDefinitionRequest',],
            'output' => ['shape' => 'CreateSubscriptionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'CreateSubscriptionDefinitionVersion' => [
            'name' => 'CreateSubscriptionDefinitionVersion',
            'http' => [
                'method' => 'POST',
                'requestUri' => '/greengrass/definition/subscriptions/{SubscriptionDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'CreateSubscriptionDefinitionVersionRequest',],
            'output' => ['shape' => 'CreateSubscriptionDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DeleteCoreDefinition' => [
            'name' => 'DeleteCoreDefinition',
            'http' => [
                'method' => 'DELETE',
                'requestUri' => '/greengrass/definition/cores/{CoreDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'DeleteCoreDefinitionRequest',],
            'output' => ['shape' => 'DeleteCoreDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DeleteDeviceDefinition' => [
            'name' => 'DeleteDeviceDefinition',
            'http' => [
                'method' => 'DELETE',
                'requestUri' => '/greengrass/definition/devices/{DeviceDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'DeleteDeviceDefinitionRequest',],
            'output' => ['shape' => 'DeleteDeviceDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DeleteFunctionDefinition' => [
            'name' => 'DeleteFunctionDefinition',
            'http' => [
                'method' => 'DELETE',
                'requestUri' => '/greengrass/definition/functions/{FunctionDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'DeleteFunctionDefinitionRequest',],
            'output' => ['shape' => 'DeleteFunctionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DeleteGroup' => [
            'name' => 'DeleteGroup',
            'http' => ['method' => 'DELETE', 'requestUri' => '/greengrass/groups/{GroupId}', 'responseCode' => 200,],
            'input' => ['shape' => 'DeleteGroupRequest',],
            'output' => ['shape' => 'DeleteGroupResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DeleteLoggerDefinition' => [
            'name' => 'DeleteLoggerDefinition',
            'http' => [
                'method' => 'DELETE',
                'requestUri' => '/greengrass/definition/loggers/{LoggerDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'DeleteLoggerDefinitionRequest',],
            'output' => ['shape' => 'DeleteLoggerDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DeleteSubscriptionDefinition' => [
            'name' => 'DeleteSubscriptionDefinition',
            'http' => [
                'method' => 'DELETE',
                'requestUri' => '/greengrass/definition/subscriptions/{SubscriptionDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'DeleteSubscriptionDefinitionRequest',],
            'output' => ['shape' => 'DeleteSubscriptionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'DisassociateRoleFromGroup' => [
            'name' => 'DisassociateRoleFromGroup',
            'http' => [
                'method' => 'DELETE',
                'requestUri' => '/greengrass/groups/{GroupId}/role',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'DisassociateRoleFromGroupRequest',],
            'output' => ['shape' => 'DisassociateRoleFromGroupResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'DisassociateServiceRoleFromAccount' => [
            'name' => 'DisassociateServiceRoleFromAccount',
            'http' => ['method' => 'DELETE', 'requestUri' => '/greengrass/servicerole', 'responseCode' => 200,],
            'input' => ['shape' => 'DisassociateServiceRoleFromAccountRequest',],
            'output' => ['shape' => 'DisassociateServiceRoleFromAccountResponse',],
            'errors' => [['shape' => 'InternalServerErrorException',],],
        ],
        'GetAssociatedRole' => [
            'name' => 'GetAssociatedRole',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/groups/{GroupId}/role', 'responseCode' => 200,],
            'input' => ['shape' => 'GetAssociatedRoleRequest',],
            'output' => ['shape' => 'GetAssociatedRoleResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'GetConnectivityInfo' => [
            'name' => 'GetConnectivityInfo',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/things/{ThingName}/connectivityInfo',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetConnectivityInfoRequest',],
            'output' => ['shape' => 'GetConnectivityInfoResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'GetCoreDefinition' => [
            'name' => 'GetCoreDefinition',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/cores/{CoreDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetCoreDefinitionRequest',],
            'output' => ['shape' => 'GetCoreDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetCoreDefinitionVersion' => [
            'name' => 'GetCoreDefinitionVersion',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/cores/{CoreDefinitionId}/versions/{CoreDefinitionVersionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetCoreDefinitionVersionRequest',],
            'output' => ['shape' => 'GetCoreDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetDeploymentStatus' => [
            'name' => 'GetDeploymentStatus',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/deployments/{DeploymentId}/status',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetDeploymentStatusRequest',],
            'output' => ['shape' => 'GetDeploymentStatusResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetDeviceDefinition' => [
            'name' => 'GetDeviceDefinition',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/devices/{DeviceDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetDeviceDefinitionRequest',],
            'output' => ['shape' => 'GetDeviceDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetDeviceDefinitionVersion' => [
            'name' => 'GetDeviceDefinitionVersion',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/devices/{DeviceDefinitionId}/versions/{DeviceDefinitionVersionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetDeviceDefinitionVersionRequest',],
            'output' => ['shape' => 'GetDeviceDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetFunctionDefinition' => [
            'name' => 'GetFunctionDefinition',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/functions/{FunctionDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetFunctionDefinitionRequest',],
            'output' => ['shape' => 'GetFunctionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetFunctionDefinitionVersion' => [
            'name' => 'GetFunctionDefinitionVersion',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/functions/{FunctionDefinitionId}/versions/{FunctionDefinitionVersionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetFunctionDefinitionVersionRequest',],
            'output' => ['shape' => 'GetFunctionDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetGroup' => [
            'name' => 'GetGroup',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/groups/{GroupId}', 'responseCode' => 200,],
            'input' => ['shape' => 'GetGroupRequest',],
            'output' => ['shape' => 'GetGroupResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetGroupCertificateAuthority' => [
            'name' => 'GetGroupCertificateAuthority',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/certificateauthorities/{CertificateAuthorityId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetGroupCertificateAuthorityRequest',],
            'output' => ['shape' => 'GetGroupCertificateAuthorityResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'GetGroupCertificateConfiguration' => [
            'name' => 'GetGroupCertificateConfiguration',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/certificateauthorities/configuration/expiry',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetGroupCertificateConfigurationRequest',],
            'output' => ['shape' => 'GetGroupCertificateConfigurationResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'GetGroupVersion' => [
            'name' => 'GetGroupVersion',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/versions/{GroupVersionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetGroupVersionRequest',],
            'output' => ['shape' => 'GetGroupVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetLoggerDefinition' => [
            'name' => 'GetLoggerDefinition',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/loggers/{LoggerDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetLoggerDefinitionRequest',],
            'output' => ['shape' => 'GetLoggerDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetLoggerDefinitionVersion' => [
            'name' => 'GetLoggerDefinitionVersion',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/loggers/{LoggerDefinitionId}/versions/{LoggerDefinitionVersionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetLoggerDefinitionVersionRequest',],
            'output' => ['shape' => 'GetLoggerDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetServiceRoleForAccount' => [
            'name' => 'GetServiceRoleForAccount',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/servicerole', 'responseCode' => 200,],
            'input' => ['shape' => 'GetServiceRoleForAccountRequest',],
            'output' => ['shape' => 'GetServiceRoleForAccountResponse',],
            'errors' => [['shape' => 'InternalServerErrorException',],],
        ],
        'GetSubscriptionDefinition' => [
            'name' => 'GetSubscriptionDefinition',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/subscriptions/{SubscriptionDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetSubscriptionDefinitionRequest',],
            'output' => ['shape' => 'GetSubscriptionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'GetSubscriptionDefinitionVersion' => [
            'name' => 'GetSubscriptionDefinitionVersion',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/subscriptions/{SubscriptionDefinitionId}/versions/{SubscriptionDefinitionVersionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'GetSubscriptionDefinitionVersionRequest',],
            'output' => ['shape' => 'GetSubscriptionDefinitionVersionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListCoreDefinitionVersions' => [
            'name' => 'ListCoreDefinitionVersions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/cores/{CoreDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListCoreDefinitionVersionsRequest',],
            'output' => ['shape' => 'ListCoreDefinitionVersionsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListCoreDefinitions' => [
            'name' => 'ListCoreDefinitions',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/definition/cores', 'responseCode' => 200,],
            'input' => ['shape' => 'ListCoreDefinitionsRequest',],
            'output' => ['shape' => 'ListCoreDefinitionsResponse',],
            'errors' => [],
        ],
        'ListDeployments' => [
            'name' => 'ListDeployments',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/deployments',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListDeploymentsRequest',],
            'output' => ['shape' => 'ListDeploymentsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListDeviceDefinitionVersions' => [
            'name' => 'ListDeviceDefinitionVersions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/devices/{DeviceDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListDeviceDefinitionVersionsRequest',],
            'output' => ['shape' => 'ListDeviceDefinitionVersionsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListDeviceDefinitions' => [
            'name' => 'ListDeviceDefinitions',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/definition/devices', 'responseCode' => 200,],
            'input' => ['shape' => 'ListDeviceDefinitionsRequest',],
            'output' => ['shape' => 'ListDeviceDefinitionsResponse',],
            'errors' => [],
        ],
        'ListFunctionDefinitionVersions' => [
            'name' => 'ListFunctionDefinitionVersions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/functions/{FunctionDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListFunctionDefinitionVersionsRequest',],
            'output' => ['shape' => 'ListFunctionDefinitionVersionsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListFunctionDefinitions' => [
            'name' => 'ListFunctionDefinitions',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/definition/functions', 'responseCode' => 200,],
            'input' => ['shape' => 'ListFunctionDefinitionsRequest',],
            'output' => ['shape' => 'ListFunctionDefinitionsResponse',],
            'errors' => [],
        ],
        'ListGroupCertificateAuthorities' => [
            'name' => 'ListGroupCertificateAuthorities',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/certificateauthorities',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListGroupCertificateAuthoritiesRequest',],
            'output' => ['shape' => 'ListGroupCertificateAuthoritiesResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'ListGroupVersions' => [
            'name' => 'ListGroupVersions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/groups/{GroupId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListGroupVersionsRequest',],
            'output' => ['shape' => 'ListGroupVersionsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListGroups' => [
            'name' => 'ListGroups',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/groups', 'responseCode' => 200,],
            'input' => ['shape' => 'ListGroupsRequest',],
            'output' => ['shape' => 'ListGroupsResponse',],
            'errors' => [],
        ],
        'ListLoggerDefinitionVersions' => [
            'name' => 'ListLoggerDefinitionVersions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/loggers/{LoggerDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListLoggerDefinitionVersionsRequest',],
            'output' => ['shape' => 'ListLoggerDefinitionVersionsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListLoggerDefinitions' => [
            'name' => 'ListLoggerDefinitions',
            'http' => ['method' => 'GET', 'requestUri' => '/greengrass/definition/loggers', 'responseCode' => 200,],
            'input' => ['shape' => 'ListLoggerDefinitionsRequest',],
            'output' => ['shape' => 'ListLoggerDefinitionsResponse',],
            'errors' => [],
        ],
        'ListSubscriptionDefinitionVersions' => [
            'name' => 'ListSubscriptionDefinitionVersions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/subscriptions/{SubscriptionDefinitionId}/versions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListSubscriptionDefinitionVersionsRequest',],
            'output' => ['shape' => 'ListSubscriptionDefinitionVersionsResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'ListSubscriptionDefinitions' => [
            'name' => 'ListSubscriptionDefinitions',
            'http' => [
                'method' => 'GET',
                'requestUri' => '/greengrass/definition/subscriptions',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'ListSubscriptionDefinitionsRequest',],
            'output' => ['shape' => 'ListSubscriptionDefinitionsResponse',],
            'errors' => [],
        ],
        'UpdateConnectivityInfo' => [
            'name' => 'UpdateConnectivityInfo',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/things/{ThingName}/connectivityInfo',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateConnectivityInfoRequest',],
            'output' => ['shape' => 'UpdateConnectivityInfoResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'UpdateCoreDefinition' => [
            'name' => 'UpdateCoreDefinition',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/definition/cores/{CoreDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateCoreDefinitionRequest',],
            'output' => ['shape' => 'UpdateCoreDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'UpdateDeviceDefinition' => [
            'name' => 'UpdateDeviceDefinition',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/definition/devices/{DeviceDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateDeviceDefinitionRequest',],
            'output' => ['shape' => 'UpdateDeviceDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'UpdateFunctionDefinition' => [
            'name' => 'UpdateFunctionDefinition',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/definition/functions/{FunctionDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateFunctionDefinitionRequest',],
            'output' => ['shape' => 'UpdateFunctionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'UpdateGroup' => [
            'name' => 'UpdateGroup',
            'http' => ['method' => 'PUT', 'requestUri' => '/greengrass/groups/{GroupId}', 'responseCode' => 200,],
            'input' => ['shape' => 'UpdateGroupRequest',],
            'output' => ['shape' => 'UpdateGroupResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'UpdateGroupCertificateConfiguration' => [
            'name' => 'UpdateGroupCertificateConfiguration',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/groups/{GroupId}/certificateauthorities/configuration/expiry',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateGroupCertificateConfigurationRequest',],
            'output' => ['shape' => 'UpdateGroupCertificateConfigurationResponse',],
            'errors' => [['shape' => 'BadRequestException',], ['shape' => 'InternalServerErrorException',],],
        ],
        'UpdateLoggerDefinition' => [
            'name' => 'UpdateLoggerDefinition',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/definition/loggers/{LoggerDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateLoggerDefinitionRequest',],
            'output' => ['shape' => 'UpdateLoggerDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
        'UpdateSubscriptionDefinition' => [
            'name' => 'UpdateSubscriptionDefinition',
            'http' => [
                'method' => 'PUT',
                'requestUri' => '/greengrass/definition/subscriptions/{SubscriptionDefinitionId}',
                'responseCode' => 200,
            ],
            'input' => ['shape' => 'UpdateSubscriptionDefinitionRequest',],
            'output' => ['shape' => 'UpdateSubscriptionDefinitionResponse',],
            'errors' => [['shape' => 'BadRequestException',],],
        ],
    ],
    'shapes' => [
        'AssociateRoleToGroupRequest' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'RoleArn' => ['shape' => '__string',],
            ],
            'required' => ['GroupId',],
        ],
        'AssociateRoleToGroupResponse' => [
            'type' => 'structure',
            'members' => ['AssociatedAt' => ['shape' => '__string',],],
        ],
        'AssociateServiceRoleToAccountRequest' => [
            'type' => 'structure',
            'members' => ['RoleArn' => ['shape' => '__string',],],
        ],
        'AssociateServiceRoleToAccountResponse' => [
            'type' => 'structure',
            'members' => ['AssociatedAt' => ['shape' => '__string',],],
        ],
        'BadRequestException' => [
            'type' => 'structure',
            'members' => ['ErrorDetails' => ['shape' => 'ErrorDetails',], 'Message' => ['shape' => '__string',],],
            'exception' => true,
            'error' => ['httpStatusCode' => 400,],
        ],
        'ConnectivityInfo' => [
            'type' => 'structure',
            'members' => [
                'HostAddress' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Metadata' => ['shape' => '__string',],
                'PortNumber' => ['shape' => '__integer',],
            ],
        ],
        'Core' => [
            'type' => 'structure',
            'members' => [
                'CertificateArn' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'SyncShadow' => ['shape' => '__boolean',],
                'ThingArn' => ['shape' => '__string',],
            ],
        ],
        'CoreDefinitionVersion' => ['type' => 'structure', 'members' => ['Cores' => ['shape' => 'ListOfCore',],],],
        'CreateCoreDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'InitialVersion' => ['shape' => 'CoreDefinitionVersion',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateCoreDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateCoreDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'CoreDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionId',
                ],
                'Cores' => ['shape' => 'ListOfCore',],
            ],
            'required' => ['CoreDefinitionId',],
        ],
        'CreateCoreDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'CreateDeploymentRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'DeploymentId' => ['shape' => '__string',],
                'DeploymentType' => ['shape' => 'DeploymentType',],
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'GroupVersionId' => ['shape' => '__string',],
            ],
            'required' => ['GroupId',],
        ],
        'CreateDeploymentResponse' => [
            'type' => 'structure',
            'members' => ['DeploymentArn' => ['shape' => '__string',], 'DeploymentId' => ['shape' => '__string',],],
        ],
        'CreateDeviceDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'InitialVersion' => ['shape' => 'DeviceDefinitionVersion',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateDeviceDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateDeviceDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'DeviceDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionId',
                ],
                'Devices' => ['shape' => 'ListOfDevice',],
            ],
            'required' => ['DeviceDefinitionId',],
        ],
        'CreateDeviceDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'CreateFunctionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'InitialVersion' => ['shape' => 'FunctionDefinitionVersion',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateFunctionDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateFunctionDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'FunctionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionId',
                ],
                'Functions' => ['shape' => 'ListOfFunction',],
            ],
            'required' => ['FunctionDefinitionId',],
        ],
        'CreateFunctionDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'CreateGroupCertificateAuthorityRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
            ],
            'required' => ['GroupId',],
        ],
        'CreateGroupCertificateAuthorityResponse' => [
            'type' => 'structure',
            'members' => ['GroupCertificateAuthorityArn' => ['shape' => '__string',],],
        ],
        'CreateGroupRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'InitialVersion' => ['shape' => 'GroupVersion',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateGroupResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateGroupVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'CoreDefinitionVersionArn' => ['shape' => '__string',],
                'DeviceDefinitionVersionArn' => ['shape' => '__string',],
                'FunctionDefinitionVersionArn' => ['shape' => '__string',],
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'LoggerDefinitionVersionArn' => ['shape' => '__string',],
                'SubscriptionDefinitionVersionArn' => ['shape' => '__string',],
            ],
            'required' => ['GroupId',],
        ],
        'CreateGroupVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'CreateLoggerDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'InitialVersion' => ['shape' => 'LoggerDefinitionVersion',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateLoggerDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateLoggerDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'LoggerDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionId',
                ],
                'Loggers' => ['shape' => 'ListOfLogger',],
            ],
            'required' => ['LoggerDefinitionId',],
        ],
        'CreateLoggerDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'CreateSubscriptionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'InitialVersion' => ['shape' => 'SubscriptionDefinitionVersion',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateSubscriptionDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'CreateSubscriptionDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'AmznClientToken' => [
                    'shape' => '__string',
                    'location' => 'header',
                    'locationName' => 'X-Amzn-Client-Token',
                ],
                'SubscriptionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionId',
                ],
                'Subscriptions' => ['shape' => 'ListOfSubscription',],
            ],
            'required' => ['SubscriptionDefinitionId',],
        ],
        'CreateSubscriptionDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'DefinitionInformation' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'DeleteCoreDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'CoreDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionId',
                ],
            ],
            'required' => ['CoreDefinitionId',],
        ],
        'DeleteCoreDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'DeleteDeviceDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'DeviceDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionId',
                ],
            ],
            'required' => ['DeviceDefinitionId',],
        ],
        'DeleteDeviceDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'DeleteFunctionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'FunctionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionId',
                ],
            ],
            'required' => ['FunctionDefinitionId',],
        ],
        'DeleteFunctionDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'DeleteGroupRequest' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],],
            'required' => ['GroupId',],
        ],
        'DeleteGroupResponse' => ['type' => 'structure', 'members' => [],],
        'DeleteLoggerDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'LoggerDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionId',
                ],
            ],
            'required' => ['LoggerDefinitionId',],
        ],
        'DeleteLoggerDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'DeleteSubscriptionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'SubscriptionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionId',
                ],
            ],
            'required' => ['SubscriptionDefinitionId',],
        ],
        'DeleteSubscriptionDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'Deployment' => [
            'type' => 'structure',
            'members' => [
                'CreatedAt' => ['shape' => '__string',],
                'DeploymentArn' => ['shape' => '__string',],
                'DeploymentId' => ['shape' => '__string',],
                'GroupArn' => ['shape' => '__string',],
            ],
        ],
        'DeploymentType' => ['type' => 'string', 'enum' => ['NewDeployment', 'Redeployment',],],
        'Deployments' => ['type' => 'list', 'member' => ['shape' => 'Deployment',],],
        'Device' => [
            'type' => 'structure',
            'members' => [
                'CertificateArn' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'SyncShadow' => ['shape' => '__boolean',],
                'ThingArn' => ['shape' => '__string',],
            ],
        ],
        'DeviceDefinitionVersion' => [
            'type' => 'structure',
            'members' => ['Devices' => ['shape' => 'ListOfDevice',],],
        ],
        'DisassociateRoleFromGroupRequest' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],],
            'required' => ['GroupId',],
        ],
        'DisassociateRoleFromGroupResponse' => [
            'type' => 'structure',
            'members' => ['DisassociatedAt' => ['shape' => '__string',],],
        ],
        'DisassociateServiceRoleFromAccountRequest' => ['type' => 'structure', 'members' => [],],
        'DisassociateServiceRoleFromAccountResponse' => [
            'type' => 'structure',
            'members' => ['DisassociatedAt' => ['shape' => '__string',],],
        ],
        'Empty' => ['type' => 'structure', 'members' => [],],
        'ErrorDetail' => [
            'type' => 'structure',
            'members' => [
                'DetailedErrorCode' => ['shape' => '__string',],
                'DetailedErrorMessage' => ['shape' => '__string',],
            ],
        ],
        'ErrorDetails' => ['type' => 'list', 'member' => ['shape' => 'ErrorDetail',],],
        'Function' => [
            'type' => 'structure',
            'members' => [
                'FunctionArn' => ['shape' => '__string',],
                'FunctionConfiguration' => ['shape' => 'FunctionConfiguration',],
                'Id' => ['shape' => '__string',],
            ],
        ],
        'FunctionConfiguration' => [
            'type' => 'structure',
            'members' => [
                'Environment' => ['shape' => 'FunctionConfigurationEnvironment',],
                'ExecArgs' => ['shape' => '__string',],
                'Executable' => ['shape' => '__string',],
                'MemorySize' => ['shape' => '__integer',],
                'Pinned' => ['shape' => '__boolean',],
                'Timeout' => ['shape' => '__integer',],
            ],
        ],
        'FunctionConfigurationEnvironment' => [
            'type' => 'structure',
            'members' => ['Variables' => ['shape' => 'MapOf__string',],],
        ],
        'FunctionDefinitionVersion' => [
            'type' => 'structure',
            'members' => ['Functions' => ['shape' => 'ListOfFunction',],],
        ],
        'GeneralError' => [
            'type' => 'structure',
            'members' => ['ErrorDetails' => ['shape' => 'ErrorDetails',], 'Message' => ['shape' => '__string',],],
        ],
        'GetAssociatedRoleRequest' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],],
            'required' => ['GroupId',],
        ],
        'GetAssociatedRoleResponse' => [
            'type' => 'structure',
            'members' => ['AssociatedAt' => ['shape' => '__string',], 'RoleArn' => ['shape' => '__string',],],
        ],
        'GetConnectivityInfoRequest' => [
            'type' => 'structure',
            'members' => ['ThingName' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'ThingName',],],
            'required' => ['ThingName',],
        ],
        'GetConnectivityInfoResponse' => [
            'type' => 'structure',
            'members' => [
                'ConnectivityInfo' => ['shape' => 'ListOfConnectivityInfo',],
                'Message' => ['shape' => '__string', 'locationName' => 'message',],
            ],
        ],
        'GetCoreDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'CoreDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionId',
                ],
            ],
            'required' => ['CoreDefinitionId',],
        ],
        'GetCoreDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GetCoreDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'CoreDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionId',
                ],
                'CoreDefinitionVersionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionVersionId',
                ],
            ],
            'required' => ['CoreDefinitionId', 'CoreDefinitionVersionId',],
        ],
        'GetCoreDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Definition' => ['shape' => 'CoreDefinitionVersion',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'GetDeploymentStatusRequest' => [
            'type' => 'structure',
            'members' => [
                'DeploymentId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeploymentId',
                ],
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
            ],
            'required' => ['GroupId', 'DeploymentId',],
        ],
        'GetDeploymentStatusResponse' => [
            'type' => 'structure',
            'members' => [
                'DeploymentStatus' => ['shape' => '__string',],
                'ErrorMessage' => ['shape' => '__string',],
                'UpdatedAt' => ['shape' => '__string',],
            ],
        ],
        'GetDeviceDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'DeviceDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionId',
                ],
            ],
            'required' => ['DeviceDefinitionId',],
        ],
        'GetDeviceDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GetDeviceDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'DeviceDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionId',
                ],
                'DeviceDefinitionVersionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionVersionId',
                ],
            ],
            'required' => ['DeviceDefinitionVersionId', 'DeviceDefinitionId',],
        ],
        'GetDeviceDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Definition' => ['shape' => 'DeviceDefinitionVersion',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'GetFunctionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'FunctionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionId',
                ],
            ],
            'required' => ['FunctionDefinitionId',],
        ],
        'GetFunctionDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GetFunctionDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'FunctionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionId',
                ],
                'FunctionDefinitionVersionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionVersionId',
                ],
            ],
            'required' => ['FunctionDefinitionId', 'FunctionDefinitionVersionId',],
        ],
        'GetFunctionDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Definition' => ['shape' => 'FunctionDefinitionVersion',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'GetGroupCertificateAuthorityRequest' => [
            'type' => 'structure',
            'members' => [
                'CertificateAuthorityId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CertificateAuthorityId',
                ],
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
            ],
            'required' => ['CertificateAuthorityId', 'GroupId',],
        ],
        'GetGroupCertificateAuthorityResponse' => [
            'type' => 'structure',
            'members' => [
                'GroupCertificateAuthorityArn' => ['shape' => '__string',],
                'GroupCertificateAuthorityId' => ['shape' => '__string',],
                'PemEncodedCertificate' => ['shape' => '__string',],
            ],
        ],
        'GetGroupCertificateConfigurationRequest' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],],
            'required' => ['GroupId',],
        ],
        'GetGroupCertificateConfigurationResponse' => [
            'type' => 'structure',
            'members' => [
                'CertificateAuthorityExpiryInMilliseconds' => ['shape' => '__string',],
                'CertificateExpiryInMilliseconds' => ['shape' => '__string',],
                'GroupId' => ['shape' => '__string',],
            ],
        ],
        'GetGroupRequest' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],],
            'required' => ['GroupId',],
        ],
        'GetGroupResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GetGroupVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'GroupVersionId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupVersionId',],
            ],
            'required' => ['GroupVersionId', 'GroupId',],
        ],
        'GetGroupVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Definition' => ['shape' => 'GroupVersion',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'GetLoggerDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'LoggerDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionId',
                ],
            ],
            'required' => ['LoggerDefinitionId',],
        ],
        'GetLoggerDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GetLoggerDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'LoggerDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionId',
                ],
                'LoggerDefinitionVersionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionVersionId',
                ],
            ],
            'required' => ['LoggerDefinitionVersionId', 'LoggerDefinitionId',],
        ],
        'GetLoggerDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Definition' => ['shape' => 'LoggerDefinitionVersion',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'GetServiceRoleForAccountRequest' => ['type' => 'structure', 'members' => [],],
        'GetServiceRoleForAccountResponse' => [
            'type' => 'structure',
            'members' => ['AssociatedAt' => ['shape' => '__string',], 'RoleArn' => ['shape' => '__string',],],
        ],
        'GetSubscriptionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'SubscriptionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionId',
                ],
            ],
            'required' => ['SubscriptionDefinitionId',],
        ],
        'GetSubscriptionDefinitionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GetSubscriptionDefinitionVersionRequest' => [
            'type' => 'structure',
            'members' => [
                'SubscriptionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionId',
                ],
                'SubscriptionDefinitionVersionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionVersionId',
                ],
            ],
            'required' => ['SubscriptionDefinitionId', 'SubscriptionDefinitionVersionId',],
        ],
        'GetSubscriptionDefinitionVersionResponse' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Definition' => ['shape' => 'SubscriptionDefinitionVersion',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'GroupCertificateAuthorityProperties' => [
            'type' => 'structure',
            'members' => [
                'GroupCertificateAuthorityArn' => ['shape' => '__string',],
                'GroupCertificateAuthorityId' => ['shape' => '__string',],
            ],
        ],
        'GroupCertificateConfiguration' => [
            'type' => 'structure',
            'members' => [
                'CertificateAuthorityExpiryInMilliseconds' => ['shape' => '__string',],
                'CertificateExpiryInMilliseconds' => ['shape' => '__string',],
                'GroupId' => ['shape' => '__string',],
            ],
        ],
        'GroupInformation' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'LastUpdatedTimestamp' => ['shape' => '__string',],
                'LatestVersion' => ['shape' => '__string',],
                'LatestVersionArn' => ['shape' => '__string',],
                'Name' => ['shape' => '__string',],
            ],
        ],
        'GroupVersion' => [
            'type' => 'structure',
            'members' => [
                'CoreDefinitionVersionArn' => ['shape' => '__string',],
                'DeviceDefinitionVersionArn' => ['shape' => '__string',],
                'FunctionDefinitionVersionArn' => ['shape' => '__string',],
                'LoggerDefinitionVersionArn' => ['shape' => '__string',],
                'SubscriptionDefinitionVersionArn' => ['shape' => '__string',],
            ],
        ],
        'InternalServerErrorException' => [
            'type' => 'structure',
            'members' => ['ErrorDetails' => ['shape' => 'ErrorDetails',], 'Message' => ['shape' => '__string',],],
            'exception' => true,
            'error' => ['httpStatusCode' => 500,],
        ],
        'ListCoreDefinitionVersionsRequest' => [
            'type' => 'structure',
            'members' => [
                'CoreDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionId',
                ],
                'MaxResults' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'MaxResults',],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
            'required' => ['CoreDefinitionId',],
        ],
        'ListCoreDefinitionVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'ListCoreDefinitionsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
        ],
        'ListCoreDefinitionsResponse' => [
            'type' => 'structure',
            'members' => [
                'Definitions' => ['shape' => 'ListOfDefinitionInformation',],
                'NextToken' => ['shape' => '__string',],
            ],
        ],
        'ListDefinitionsResponse' => [
            'type' => 'structure',
            'members' => [
                'Definitions' => ['shape' => 'ListOfDefinitionInformation',],
                'NextToken' => ['shape' => '__string',],
            ],
        ],
        'ListDeploymentsRequest' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'MaxResults' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'MaxResults',],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
            'required' => ['GroupId',],
        ],
        'ListDeploymentsResponse' => [
            'type' => 'structure',
            'members' => ['Deployments' => ['shape' => 'Deployments',], 'NextToken' => ['shape' => '__string',],],
        ],
        'ListDeviceDefinitionVersionsRequest' => [
            'type' => 'structure',
            'members' => [
                'DeviceDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionId',
                ],
                'MaxResults' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'MaxResults',],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
            'required' => ['DeviceDefinitionId',],
        ],
        'ListDeviceDefinitionVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'ListDeviceDefinitionsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
        ],
        'ListDeviceDefinitionsResponse' => [
            'type' => 'structure',
            'members' => [
                'Definitions' => ['shape' => 'ListOfDefinitionInformation',],
                'NextToken' => ['shape' => '__string',],
            ],
        ],
        'ListFunctionDefinitionVersionsRequest' => [
            'type' => 'structure',
            'members' => [
                'FunctionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionId',
                ],
                'MaxResults' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'MaxResults',],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
            'required' => ['FunctionDefinitionId',],
        ],
        'ListFunctionDefinitionVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'ListFunctionDefinitionsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
        ],
        'ListFunctionDefinitionsResponse' => [
            'type' => 'structure',
            'members' => [
                'Definitions' => ['shape' => 'ListOfDefinitionInformation',],
                'NextToken' => ['shape' => '__string',],
            ],
        ],
        'ListGroupCertificateAuthoritiesRequest' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],],
            'required' => ['GroupId',],
        ],
        'ListGroupCertificateAuthoritiesResponse' => [
            'type' => 'structure',
            'members' => ['GroupCertificateAuthorities' => ['shape' => 'ListOfGroupCertificateAuthorityProperties',],],
        ],
        'ListGroupVersionsRequest' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'MaxResults' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'MaxResults',],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
            'required' => ['GroupId',],
        ],
        'ListGroupVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'ListGroupsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
        ],
        'ListGroupsResponse' => [
            'type' => 'structure',
            'members' => ['Groups' => ['shape' => 'ListOfGroupInformation',], 'NextToken' => ['shape' => '__string',],],
        ],
        'ListLoggerDefinitionVersionsRequest' => [
            'type' => 'structure',
            'members' => [
                'LoggerDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionId',
                ],
                'MaxResults' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'MaxResults',],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
            'required' => ['LoggerDefinitionId',],
        ],
        'ListLoggerDefinitionVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'ListLoggerDefinitionsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
        ],
        'ListLoggerDefinitionsResponse' => [
            'type' => 'structure',
            'members' => [
                'Definitions' => ['shape' => 'ListOfDefinitionInformation',],
                'NextToken' => ['shape' => '__string',],
            ],
        ],
        'ListOfConnectivityInfo' => ['type' => 'list', 'member' => ['shape' => 'ConnectivityInfo',],],
        'ListOfCore' => ['type' => 'list', 'member' => ['shape' => 'Core',],],
        'ListOfDefinitionInformation' => ['type' => 'list', 'member' => ['shape' => 'DefinitionInformation',],],
        'ListOfDevice' => ['type' => 'list', 'member' => ['shape' => 'Device',],],
        'ListOfFunction' => ['type' => 'list', 'member' => ['shape' => 'Function',],],
        'ListOfGroupCertificateAuthorityProperties' => [
            'type' => 'list',
            'member' => ['shape' => 'GroupCertificateAuthorityProperties',],
        ],
        'ListOfGroupInformation' => ['type' => 'list', 'member' => ['shape' => 'GroupInformation',],],
        'ListOfLogger' => ['type' => 'list', 'member' => ['shape' => 'Logger',],],
        'ListOfSubscription' => ['type' => 'list', 'member' => ['shape' => 'Subscription',],],
        'ListOfVersionInformation' => ['type' => 'list', 'member' => ['shape' => 'VersionInformation',],],
        'ListSubscriptionDefinitionVersionsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
                'SubscriptionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionId',
                ],
            ],
            'required' => ['SubscriptionDefinitionId',],
        ],
        'ListSubscriptionDefinitionVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'ListSubscriptionDefinitionsRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => [
                    'shape' => '__string',
                    'location' => 'querystring',
                    'locationName' => 'MaxResults',
                ],
                'NextToken' => ['shape' => '__string', 'location' => 'querystring', 'locationName' => 'NextToken',],
            ],
        ],
        'ListSubscriptionDefinitionsResponse' => [
            'type' => 'structure',
            'members' => [
                'Definitions' => ['shape' => 'ListOfDefinitionInformation',],
                'NextToken' => ['shape' => '__string',],
            ],
        ],
        'ListVersionsResponse' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => '__string',],
                'Versions' => ['shape' => 'ListOfVersionInformation',],
            ],
        ],
        'Logger' => [
            'type' => 'structure',
            'members' => [
                'Component' => ['shape' => 'LoggerComponent',],
                'Id' => ['shape' => '__string',],
                'Level' => ['shape' => 'LoggerLevel',],
                'Space' => ['shape' => '__integer',],
                'Type' => ['shape' => 'LoggerType',],
            ],
        ],
        'LoggerComponent' => ['type' => 'string', 'enum' => ['GreengrassSystem', 'Lambda',],],
        'LoggerDefinitionVersion' => [
            'type' => 'structure',
            'members' => ['Loggers' => ['shape' => 'ListOfLogger',],],
        ],
        'LoggerLevel' => ['type' => 'string', 'enum' => ['DEBUG', 'INFO', 'WARN', 'ERROR', 'FATAL',],],
        'LoggerType' => ['type' => 'string', 'enum' => ['FileSystem', 'AWSCloudWatch',],],
        'MapOf__string' => ['type' => 'map', 'key' => ['shape' => '__string',], 'value' => ['shape' => '__string',],],
        'Subscription' => [
            'type' => 'structure',
            'members' => [
                'Id' => ['shape' => '__string',],
                'Source' => ['shape' => '__string',],
                'Subject' => ['shape' => '__string',],
                'Target' => ['shape' => '__string',],
            ],
        ],
        'SubscriptionDefinitionVersion' => [
            'type' => 'structure',
            'members' => ['Subscriptions' => ['shape' => 'ListOfSubscription',],],
        ],
        'UpdateConnectivityInfoRequest' => [
            'type' => 'structure',
            'members' => [
                'ConnectivityInfo' => ['shape' => 'ListOfConnectivityInfo',],
                'ThingName' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'ThingName',],
            ],
            'required' => ['ThingName',],
        ],
        'UpdateConnectivityInfoResponse' => [
            'type' => 'structure',
            'members' => [
                'Message' => ['shape' => '__string', 'locationName' => 'message',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        'UpdateCoreDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'CoreDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'CoreDefinitionId',
                ],
                'Name' => ['shape' => '__string',],
            ],
            'required' => ['CoreDefinitionId',],
        ],
        'UpdateCoreDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'UpdateDeviceDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'DeviceDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'DeviceDefinitionId',
                ],
                'Name' => ['shape' => '__string',],
            ],
            'required' => ['DeviceDefinitionId',],
        ],
        'UpdateDeviceDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'UpdateFunctionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'FunctionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'FunctionDefinitionId',
                ],
                'Name' => ['shape' => '__string',],
            ],
            'required' => ['FunctionDefinitionId',],
        ],
        'UpdateFunctionDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'UpdateGroupCertificateConfigurationRequest' => [
            'type' => 'structure',
            'members' => [
                'CertificateExpiryInMilliseconds' => ['shape' => '__string',],
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
            ],
            'required' => ['GroupId',],
        ],
        'UpdateGroupCertificateConfigurationResponse' => [
            'type' => 'structure',
            'members' => [
                'CertificateAuthorityExpiryInMilliseconds' => ['shape' => '__string',],
                'CertificateExpiryInMilliseconds' => ['shape' => '__string',],
                'GroupId' => ['shape' => '__string',],
            ],
        ],
        'UpdateGroupRequest' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => '__string', 'location' => 'uri', 'locationName' => 'GroupId',],
                'Name' => ['shape' => '__string',],
            ],
            'required' => ['GroupId',],
        ],
        'UpdateGroupResponse' => ['type' => 'structure', 'members' => [],],
        'UpdateLoggerDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'LoggerDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'LoggerDefinitionId',
                ],
                'Name' => ['shape' => '__string',],
            ],
            'required' => ['LoggerDefinitionId',],
        ],
        'UpdateLoggerDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'UpdateSubscriptionDefinitionRequest' => [
            'type' => 'structure',
            'members' => [
                'Name' => ['shape' => '__string',],
                'SubscriptionDefinitionId' => [
                    'shape' => '__string',
                    'location' => 'uri',
                    'locationName' => 'SubscriptionDefinitionId',
                ],
            ],
            'required' => ['SubscriptionDefinitionId',],
        ],
        'UpdateSubscriptionDefinitionResponse' => ['type' => 'structure', 'members' => [],],
        'VersionInformation' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => '__string',],
                'CreationTimestamp' => ['shape' => '__string',],
                'Id' => ['shape' => '__string',],
                'Version' => ['shape' => '__string',],
            ],
        ],
        '__boolean' => ['type' => 'boolean',],
        '__double' => ['type' => 'double',],
        '__integer' => ['type' => 'integer',],
        '__string' => ['type' => 'string',],
        '__timestamp' => ['type' => 'timestamp',],
    ],
];
