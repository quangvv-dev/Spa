<?php
// This file was auto-generated from sdk-root/src/data/ec2/2016-11-15/api-2.json
return [
    'version' => '2.0',
    'metadata' => [
        'apiVersion' => '2016-11-15',
        'endpointPrefix' => 'ec2',
        'protocol' => 'ec2',
        'serviceAbbreviation' => 'Amazon EC2',
        'serviceFullName' => 'Amazon Elastic Compute Cloud',
        'signatureVersion' => 'v4',
        'uid' => 'ec2-2016-11-15',
        'xmlNamespace' => 'http://ec2.amazonaws.com/doc/2016-11-15',
    ],
    'operations' => [
        'AcceptReservedInstancesExchangeQuote' => [
            'name' => 'AcceptReservedInstancesExchangeQuote',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AcceptReservedInstancesExchangeQuoteRequest',],
            'output' => ['shape' => 'AcceptReservedInstancesExchangeQuoteResult',],
        ],
        'AcceptVpcPeeringConnection' => [
            'name' => 'AcceptVpcPeeringConnection',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AcceptVpcPeeringConnectionRequest',],
            'output' => ['shape' => 'AcceptVpcPeeringConnectionResult',],
        ],
        'AllocateAddress' => [
            'name' => 'AllocateAddress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AllocateAddressRequest',],
            'output' => ['shape' => 'AllocateAddressResult',],
        ],
        'AllocateHosts' => [
            'name' => 'AllocateHosts',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AllocateHostsRequest',],
            'output' => ['shape' => 'AllocateHostsResult',],
        ],
        'AssignIpv6Addresses' => [
            'name' => 'AssignIpv6Addresses',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssignIpv6AddressesRequest',],
            'output' => ['shape' => 'AssignIpv6AddressesResult',],
        ],
        'AssignPrivateIpAddresses' => [
            'name' => 'AssignPrivateIpAddresses',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssignPrivateIpAddressesRequest',],
        ],
        'AssociateAddress' => [
            'name' => 'AssociateAddress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssociateAddressRequest',],
            'output' => ['shape' => 'AssociateAddressResult',],
        ],
        'AssociateDhcpOptions' => [
            'name' => 'AssociateDhcpOptions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssociateDhcpOptionsRequest',],
        ],
        'AssociateIamInstanceProfile' => [
            'name' => 'AssociateIamInstanceProfile',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssociateIamInstanceProfileRequest',],
            'output' => ['shape' => 'AssociateIamInstanceProfileResult',],
        ],
        'AssociateRouteTable' => [
            'name' => 'AssociateRouteTable',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssociateRouteTableRequest',],
            'output' => ['shape' => 'AssociateRouteTableResult',],
        ],
        'AssociateSubnetCidrBlock' => [
            'name' => 'AssociateSubnetCidrBlock',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssociateSubnetCidrBlockRequest',],
            'output' => ['shape' => 'AssociateSubnetCidrBlockResult',],
        ],
        'AssociateVpcCidrBlock' => [
            'name' => 'AssociateVpcCidrBlock',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AssociateVpcCidrBlockRequest',],
            'output' => ['shape' => 'AssociateVpcCidrBlockResult',],
        ],
        'AttachClassicLinkVpc' => [
            'name' => 'AttachClassicLinkVpc',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AttachClassicLinkVpcRequest',],
            'output' => ['shape' => 'AttachClassicLinkVpcResult',],
        ],
        'AttachInternetGateway' => [
            'name' => 'AttachInternetGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AttachInternetGatewayRequest',],
        ],
        'AttachNetworkInterface' => [
            'name' => 'AttachNetworkInterface',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AttachNetworkInterfaceRequest',],
            'output' => ['shape' => 'AttachNetworkInterfaceResult',],
        ],
        'AttachVolume' => [
            'name' => 'AttachVolume',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AttachVolumeRequest',],
            'output' => ['shape' => 'VolumeAttachment',],
        ],
        'AttachVpnGateway' => [
            'name' => 'AttachVpnGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AttachVpnGatewayRequest',],
            'output' => ['shape' => 'AttachVpnGatewayResult',],
        ],
        'AuthorizeSecurityGroupEgress' => [
            'name' => 'AuthorizeSecurityGroupEgress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AuthorizeSecurityGroupEgressRequest',],
        ],
        'AuthorizeSecurityGroupIngress' => [
            'name' => 'AuthorizeSecurityGroupIngress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'AuthorizeSecurityGroupIngressRequest',],
        ],
        'BundleInstance' => [
            'name' => 'BundleInstance',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'BundleInstanceRequest',],
            'output' => ['shape' => 'BundleInstanceResult',],
        ],
        'CancelBundleTask' => [
            'name' => 'CancelBundleTask',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelBundleTaskRequest',],
            'output' => ['shape' => 'CancelBundleTaskResult',],
        ],
        'CancelConversionTask' => [
            'name' => 'CancelConversionTask',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelConversionRequest',],
        ],
        'CancelExportTask' => [
            'name' => 'CancelExportTask',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelExportTaskRequest',],
        ],
        'CancelImportTask' => [
            'name' => 'CancelImportTask',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelImportTaskRequest',],
            'output' => ['shape' => 'CancelImportTaskResult',],
        ],
        'CancelReservedInstancesListing' => [
            'name' => 'CancelReservedInstancesListing',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelReservedInstancesListingRequest',],
            'output' => ['shape' => 'CancelReservedInstancesListingResult',],
        ],
        'CancelSpotFleetRequests' => [
            'name' => 'CancelSpotFleetRequests',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelSpotFleetRequestsRequest',],
            'output' => ['shape' => 'CancelSpotFleetRequestsResponse',],
        ],
        'CancelSpotInstanceRequests' => [
            'name' => 'CancelSpotInstanceRequests',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CancelSpotInstanceRequestsRequest',],
            'output' => ['shape' => 'CancelSpotInstanceRequestsResult',],
        ],
        'ConfirmProductInstance' => [
            'name' => 'ConfirmProductInstance',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ConfirmProductInstanceRequest',],
            'output' => ['shape' => 'ConfirmProductInstanceResult',],
        ],
        'CopyImage' => [
            'name' => 'CopyImage',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CopyImageRequest',],
            'output' => ['shape' => 'CopyImageResult',],
        ],
        'CopySnapshot' => [
            'name' => 'CopySnapshot',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CopySnapshotRequest',],
            'output' => ['shape' => 'CopySnapshotResult',],
        ],
        'CreateCustomerGateway' => [
            'name' => 'CreateCustomerGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateCustomerGatewayRequest',],
            'output' => ['shape' => 'CreateCustomerGatewayResult',],
        ],
        'CreateDhcpOptions' => [
            'name' => 'CreateDhcpOptions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateDhcpOptionsRequest',],
            'output' => ['shape' => 'CreateDhcpOptionsResult',],
        ],
        'CreateEgressOnlyInternetGateway' => [
            'name' => 'CreateEgressOnlyInternetGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateEgressOnlyInternetGatewayRequest',],
            'output' => ['shape' => 'CreateEgressOnlyInternetGatewayResult',],
        ],
        'CreateFlowLogs' => [
            'name' => 'CreateFlowLogs',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateFlowLogsRequest',],
            'output' => ['shape' => 'CreateFlowLogsResult',],
        ],
        'CreateFpgaImage' => [
            'name' => 'CreateFpgaImage',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateFpgaImageRequest',],
            'output' => ['shape' => 'CreateFpgaImageResult',],
        ],
        'CreateImage' => [
            'name' => 'CreateImage',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateImageRequest',],
            'output' => ['shape' => 'CreateImageResult',],
        ],
        'CreateInstanceExportTask' => [
            'name' => 'CreateInstanceExportTask',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateInstanceExportTaskRequest',],
            'output' => ['shape' => 'CreateInstanceExportTaskResult',],
        ],
        'CreateInternetGateway' => [
            'name' => 'CreateInternetGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateInternetGatewayRequest',],
            'output' => ['shape' => 'CreateInternetGatewayResult',],
        ],
        'CreateKeyPair' => [
            'name' => 'CreateKeyPair',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateKeyPairRequest',],
            'output' => ['shape' => 'KeyPair',],
        ],
        'CreateNatGateway' => [
            'name' => 'CreateNatGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateNatGatewayRequest',],
            'output' => ['shape' => 'CreateNatGatewayResult',],
        ],
        'CreateNetworkAcl' => [
            'name' => 'CreateNetworkAcl',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateNetworkAclRequest',],
            'output' => ['shape' => 'CreateNetworkAclResult',],
        ],
        'CreateNetworkAclEntry' => [
            'name' => 'CreateNetworkAclEntry',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateNetworkAclEntryRequest',],
        ],
        'CreateNetworkInterface' => [
            'name' => 'CreateNetworkInterface',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateNetworkInterfaceRequest',],
            'output' => ['shape' => 'CreateNetworkInterfaceResult',],
        ],
        'CreatePlacementGroup' => [
            'name' => 'CreatePlacementGroup',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreatePlacementGroupRequest',],
        ],
        'CreateReservedInstancesListing' => [
            'name' => 'CreateReservedInstancesListing',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateReservedInstancesListingRequest',],
            'output' => ['shape' => 'CreateReservedInstancesListingResult',],
        ],
        'CreateRoute' => [
            'name' => 'CreateRoute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateRouteRequest',],
            'output' => ['shape' => 'CreateRouteResult',],
        ],
        'CreateRouteTable' => [
            'name' => 'CreateRouteTable',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateRouteTableRequest',],
            'output' => ['shape' => 'CreateRouteTableResult',],
        ],
        'CreateSecurityGroup' => [
            'name' => 'CreateSecurityGroup',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateSecurityGroupRequest',],
            'output' => ['shape' => 'CreateSecurityGroupResult',],
        ],
        'CreateSnapshot' => [
            'name' => 'CreateSnapshot',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateSnapshotRequest',],
            'output' => ['shape' => 'Snapshot',],
        ],
        'CreateSpotDatafeedSubscription' => [
            'name' => 'CreateSpotDatafeedSubscription',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateSpotDatafeedSubscriptionRequest',],
            'output' => ['shape' => 'CreateSpotDatafeedSubscriptionResult',],
        ],
        'CreateSubnet' => [
            'name' => 'CreateSubnet',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateSubnetRequest',],
            'output' => ['shape' => 'CreateSubnetResult',],
        ],
        'CreateTags' => [
            'name' => 'CreateTags',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateTagsRequest',],
        ],
        'CreateVolume' => [
            'name' => 'CreateVolume',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVolumeRequest',],
            'output' => ['shape' => 'Volume',],
        ],
        'CreateVpc' => [
            'name' => 'CreateVpc',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVpcRequest',],
            'output' => ['shape' => 'CreateVpcResult',],
        ],
        'CreateVpcEndpoint' => [
            'name' => 'CreateVpcEndpoint',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVpcEndpointRequest',],
            'output' => ['shape' => 'CreateVpcEndpointResult',],
        ],
        'CreateVpcPeeringConnection' => [
            'name' => 'CreateVpcPeeringConnection',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVpcPeeringConnectionRequest',],
            'output' => ['shape' => 'CreateVpcPeeringConnectionResult',],
        ],
        'CreateVpnConnection' => [
            'name' => 'CreateVpnConnection',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVpnConnectionRequest',],
            'output' => ['shape' => 'CreateVpnConnectionResult',],
        ],
        'CreateVpnConnectionRoute' => [
            'name' => 'CreateVpnConnectionRoute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVpnConnectionRouteRequest',],
        ],
        'CreateVpnGateway' => [
            'name' => 'CreateVpnGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'CreateVpnGatewayRequest',],
            'output' => ['shape' => 'CreateVpnGatewayResult',],
        ],
        'DeleteCustomerGateway' => [
            'name' => 'DeleteCustomerGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteCustomerGatewayRequest',],
        ],
        'DeleteDhcpOptions' => [
            'name' => 'DeleteDhcpOptions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteDhcpOptionsRequest',],
        ],
        'DeleteEgressOnlyInternetGateway' => [
            'name' => 'DeleteEgressOnlyInternetGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteEgressOnlyInternetGatewayRequest',],
            'output' => ['shape' => 'DeleteEgressOnlyInternetGatewayResult',],
        ],
        'DeleteFlowLogs' => [
            'name' => 'DeleteFlowLogs',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteFlowLogsRequest',],
            'output' => ['shape' => 'DeleteFlowLogsResult',],
        ],
        'DeleteInternetGateway' => [
            'name' => 'DeleteInternetGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteInternetGatewayRequest',],
        ],
        'DeleteKeyPair' => [
            'name' => 'DeleteKeyPair',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteKeyPairRequest',],
        ],
        'DeleteNatGateway' => [
            'name' => 'DeleteNatGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteNatGatewayRequest',],
            'output' => ['shape' => 'DeleteNatGatewayResult',],
        ],
        'DeleteNetworkAcl' => [
            'name' => 'DeleteNetworkAcl',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteNetworkAclRequest',],
        ],
        'DeleteNetworkAclEntry' => [
            'name' => 'DeleteNetworkAclEntry',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteNetworkAclEntryRequest',],
        ],
        'DeleteNetworkInterface' => [
            'name' => 'DeleteNetworkInterface',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteNetworkInterfaceRequest',],
        ],
        'DeletePlacementGroup' => [
            'name' => 'DeletePlacementGroup',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeletePlacementGroupRequest',],
        ],
        'DeleteRoute' => [
            'name' => 'DeleteRoute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteRouteRequest',],
        ],
        'DeleteRouteTable' => [
            'name' => 'DeleteRouteTable',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteRouteTableRequest',],
        ],
        'DeleteSecurityGroup' => [
            'name' => 'DeleteSecurityGroup',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteSecurityGroupRequest',],
        ],
        'DeleteSnapshot' => [
            'name' => 'DeleteSnapshot',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteSnapshotRequest',],
        ],
        'DeleteSpotDatafeedSubscription' => [
            'name' => 'DeleteSpotDatafeedSubscription',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteSpotDatafeedSubscriptionRequest',],
        ],
        'DeleteSubnet' => [
            'name' => 'DeleteSubnet',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteSubnetRequest',],
        ],
        'DeleteTags' => [
            'name' => 'DeleteTags',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteTagsRequest',],
        ],
        'DeleteVolume' => [
            'name' => 'DeleteVolume',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVolumeRequest',],
        ],
        'DeleteVpc' => [
            'name' => 'DeleteVpc',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVpcRequest',],
        ],
        'DeleteVpcEndpoints' => [
            'name' => 'DeleteVpcEndpoints',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVpcEndpointsRequest',],
            'output' => ['shape' => 'DeleteVpcEndpointsResult',],
        ],
        'DeleteVpcPeeringConnection' => [
            'name' => 'DeleteVpcPeeringConnection',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVpcPeeringConnectionRequest',],
            'output' => ['shape' => 'DeleteVpcPeeringConnectionResult',],
        ],
        'DeleteVpnConnection' => [
            'name' => 'DeleteVpnConnection',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVpnConnectionRequest',],
        ],
        'DeleteVpnConnectionRoute' => [
            'name' => 'DeleteVpnConnectionRoute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVpnConnectionRouteRequest',],
        ],
        'DeleteVpnGateway' => [
            'name' => 'DeleteVpnGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeleteVpnGatewayRequest',],
        ],
        'DeregisterImage' => [
            'name' => 'DeregisterImage',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DeregisterImageRequest',],
        ],
        'DescribeAccountAttributes' => [
            'name' => 'DescribeAccountAttributes',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeAccountAttributesRequest',],
            'output' => ['shape' => 'DescribeAccountAttributesResult',],
        ],
        'DescribeAddresses' => [
            'name' => 'DescribeAddresses',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeAddressesRequest',],
            'output' => ['shape' => 'DescribeAddressesResult',],
        ],
        'DescribeAvailabilityZones' => [
            'name' => 'DescribeAvailabilityZones',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeAvailabilityZonesRequest',],
            'output' => ['shape' => 'DescribeAvailabilityZonesResult',],
        ],
        'DescribeBundleTasks' => [
            'name' => 'DescribeBundleTasks',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeBundleTasksRequest',],
            'output' => ['shape' => 'DescribeBundleTasksResult',],
        ],
        'DescribeClassicLinkInstances' => [
            'name' => 'DescribeClassicLinkInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeClassicLinkInstancesRequest',],
            'output' => ['shape' => 'DescribeClassicLinkInstancesResult',],
        ],
        'DescribeConversionTasks' => [
            'name' => 'DescribeConversionTasks',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeConversionTasksRequest',],
            'output' => ['shape' => 'DescribeConversionTasksResult',],
        ],
        'DescribeCustomerGateways' => [
            'name' => 'DescribeCustomerGateways',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeCustomerGatewaysRequest',],
            'output' => ['shape' => 'DescribeCustomerGatewaysResult',],
        ],
        'DescribeDhcpOptions' => [
            'name' => 'DescribeDhcpOptions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeDhcpOptionsRequest',],
            'output' => ['shape' => 'DescribeDhcpOptionsResult',],
        ],
        'DescribeEgressOnlyInternetGateways' => [
            'name' => 'DescribeEgressOnlyInternetGateways',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeEgressOnlyInternetGatewaysRequest',],
            'output' => ['shape' => 'DescribeEgressOnlyInternetGatewaysResult',],
        ],
        'DescribeExportTasks' => [
            'name' => 'DescribeExportTasks',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeExportTasksRequest',],
            'output' => ['shape' => 'DescribeExportTasksResult',],
        ],
        'DescribeFlowLogs' => [
            'name' => 'DescribeFlowLogs',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeFlowLogsRequest',],
            'output' => ['shape' => 'DescribeFlowLogsResult',],
        ],
        'DescribeFpgaImages' => [
            'name' => 'DescribeFpgaImages',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeFpgaImagesRequest',],
            'output' => ['shape' => 'DescribeFpgaImagesResult',],
        ],
        'DescribeHostReservationOfferings' => [
            'name' => 'DescribeHostReservationOfferings',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeHostReservationOfferingsRequest',],
            'output' => ['shape' => 'DescribeHostReservationOfferingsResult',],
        ],
        'DescribeHostReservations' => [
            'name' => 'DescribeHostReservations',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeHostReservationsRequest',],
            'output' => ['shape' => 'DescribeHostReservationsResult',],
        ],
        'DescribeHosts' => [
            'name' => 'DescribeHosts',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeHostsRequest',],
            'output' => ['shape' => 'DescribeHostsResult',],
        ],
        'DescribeIamInstanceProfileAssociations' => [
            'name' => 'DescribeIamInstanceProfileAssociations',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeIamInstanceProfileAssociationsRequest',],
            'output' => ['shape' => 'DescribeIamInstanceProfileAssociationsResult',],
        ],
        'DescribeIdFormat' => [
            'name' => 'DescribeIdFormat',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeIdFormatRequest',],
            'output' => ['shape' => 'DescribeIdFormatResult',],
        ],
        'DescribeIdentityIdFormat' => [
            'name' => 'DescribeIdentityIdFormat',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeIdentityIdFormatRequest',],
            'output' => ['shape' => 'DescribeIdentityIdFormatResult',],
        ],
        'DescribeImageAttribute' => [
            'name' => 'DescribeImageAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeImageAttributeRequest',],
            'output' => ['shape' => 'ImageAttribute',],
        ],
        'DescribeImages' => [
            'name' => 'DescribeImages',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeImagesRequest',],
            'output' => ['shape' => 'DescribeImagesResult',],
        ],
        'DescribeImportImageTasks' => [
            'name' => 'DescribeImportImageTasks',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeImportImageTasksRequest',],
            'output' => ['shape' => 'DescribeImportImageTasksResult',],
        ],
        'DescribeImportSnapshotTasks' => [
            'name' => 'DescribeImportSnapshotTasks',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeImportSnapshotTasksRequest',],
            'output' => ['shape' => 'DescribeImportSnapshotTasksResult',],
        ],
        'DescribeInstanceAttribute' => [
            'name' => 'DescribeInstanceAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeInstanceAttributeRequest',],
            'output' => ['shape' => 'InstanceAttribute',],
        ],
        'DescribeInstanceStatus' => [
            'name' => 'DescribeInstanceStatus',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeInstanceStatusRequest',],
            'output' => ['shape' => 'DescribeInstanceStatusResult',],
        ],
        'DescribeInstances' => [
            'name' => 'DescribeInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeInstancesRequest',],
            'output' => ['shape' => 'DescribeInstancesResult',],
        ],
        'DescribeInternetGateways' => [
            'name' => 'DescribeInternetGateways',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeInternetGatewaysRequest',],
            'output' => ['shape' => 'DescribeInternetGatewaysResult',],
        ],
        'DescribeKeyPairs' => [
            'name' => 'DescribeKeyPairs',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeKeyPairsRequest',],
            'output' => ['shape' => 'DescribeKeyPairsResult',],
        ],
        'DescribeMovingAddresses' => [
            'name' => 'DescribeMovingAddresses',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeMovingAddressesRequest',],
            'output' => ['shape' => 'DescribeMovingAddressesResult',],
        ],
        'DescribeNatGateways' => [
            'name' => 'DescribeNatGateways',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeNatGatewaysRequest',],
            'output' => ['shape' => 'DescribeNatGatewaysResult',],
        ],
        'DescribeNetworkAcls' => [
            'name' => 'DescribeNetworkAcls',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeNetworkAclsRequest',],
            'output' => ['shape' => 'DescribeNetworkAclsResult',],
        ],
        'DescribeNetworkInterfaceAttribute' => [
            'name' => 'DescribeNetworkInterfaceAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeNetworkInterfaceAttributeRequest',],
            'output' => ['shape' => 'DescribeNetworkInterfaceAttributeResult',],
        ],
        'DescribeNetworkInterfaces' => [
            'name' => 'DescribeNetworkInterfaces',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeNetworkInterfacesRequest',],
            'output' => ['shape' => 'DescribeNetworkInterfacesResult',],
        ],
        'DescribePlacementGroups' => [
            'name' => 'DescribePlacementGroups',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribePlacementGroupsRequest',],
            'output' => ['shape' => 'DescribePlacementGroupsResult',],
        ],
        'DescribePrefixLists' => [
            'name' => 'DescribePrefixLists',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribePrefixListsRequest',],
            'output' => ['shape' => 'DescribePrefixListsResult',],
        ],
        'DescribeRegions' => [
            'name' => 'DescribeRegions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeRegionsRequest',],
            'output' => ['shape' => 'DescribeRegionsResult',],
        ],
        'DescribeReservedInstances' => [
            'name' => 'DescribeReservedInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeReservedInstancesRequest',],
            'output' => ['shape' => 'DescribeReservedInstancesResult',],
        ],
        'DescribeReservedInstancesListings' => [
            'name' => 'DescribeReservedInstancesListings',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeReservedInstancesListingsRequest',],
            'output' => ['shape' => 'DescribeReservedInstancesListingsResult',],
        ],
        'DescribeReservedInstancesModifications' => [
            'name' => 'DescribeReservedInstancesModifications',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeReservedInstancesModificationsRequest',],
            'output' => ['shape' => 'DescribeReservedInstancesModificationsResult',],
        ],
        'DescribeReservedInstancesOfferings' => [
            'name' => 'DescribeReservedInstancesOfferings',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeReservedInstancesOfferingsRequest',],
            'output' => ['shape' => 'DescribeReservedInstancesOfferingsResult',],
        ],
        'DescribeRouteTables' => [
            'name' => 'DescribeRouteTables',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeRouteTablesRequest',],
            'output' => ['shape' => 'DescribeRouteTablesResult',],
        ],
        'DescribeScheduledInstanceAvailability' => [
            'name' => 'DescribeScheduledInstanceAvailability',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeScheduledInstanceAvailabilityRequest',],
            'output' => ['shape' => 'DescribeScheduledInstanceAvailabilityResult',],
        ],
        'DescribeScheduledInstances' => [
            'name' => 'DescribeScheduledInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeScheduledInstancesRequest',],
            'output' => ['shape' => 'DescribeScheduledInstancesResult',],
        ],
        'DescribeSecurityGroupReferences' => [
            'name' => 'DescribeSecurityGroupReferences',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSecurityGroupReferencesRequest',],
            'output' => ['shape' => 'DescribeSecurityGroupReferencesResult',],
        ],
        'DescribeSecurityGroups' => [
            'name' => 'DescribeSecurityGroups',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSecurityGroupsRequest',],
            'output' => ['shape' => 'DescribeSecurityGroupsResult',],
        ],
        'DescribeSnapshotAttribute' => [
            'name' => 'DescribeSnapshotAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSnapshotAttributeRequest',],
            'output' => ['shape' => 'DescribeSnapshotAttributeResult',],
        ],
        'DescribeSnapshots' => [
            'name' => 'DescribeSnapshots',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSnapshotsRequest',],
            'output' => ['shape' => 'DescribeSnapshotsResult',],
        ],
        'DescribeSpotDatafeedSubscription' => [
            'name' => 'DescribeSpotDatafeedSubscription',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSpotDatafeedSubscriptionRequest',],
            'output' => ['shape' => 'DescribeSpotDatafeedSubscriptionResult',],
        ],
        'DescribeSpotFleetInstances' => [
            'name' => 'DescribeSpotFleetInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSpotFleetInstancesRequest',],
            'output' => ['shape' => 'DescribeSpotFleetInstancesResponse',],
        ],
        'DescribeSpotFleetRequestHistory' => [
            'name' => 'DescribeSpotFleetRequestHistory',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSpotFleetRequestHistoryRequest',],
            'output' => ['shape' => 'DescribeSpotFleetRequestHistoryResponse',],
        ],
        'DescribeSpotFleetRequests' => [
            'name' => 'DescribeSpotFleetRequests',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSpotFleetRequestsRequest',],
            'output' => ['shape' => 'DescribeSpotFleetRequestsResponse',],
        ],
        'DescribeSpotInstanceRequests' => [
            'name' => 'DescribeSpotInstanceRequests',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSpotInstanceRequestsRequest',],
            'output' => ['shape' => 'DescribeSpotInstanceRequestsResult',],
        ],
        'DescribeSpotPriceHistory' => [
            'name' => 'DescribeSpotPriceHistory',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSpotPriceHistoryRequest',],
            'output' => ['shape' => 'DescribeSpotPriceHistoryResult',],
        ],
        'DescribeStaleSecurityGroups' => [
            'name' => 'DescribeStaleSecurityGroups',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeStaleSecurityGroupsRequest',],
            'output' => ['shape' => 'DescribeStaleSecurityGroupsResult',],
        ],
        'DescribeSubnets' => [
            'name' => 'DescribeSubnets',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeSubnetsRequest',],
            'output' => ['shape' => 'DescribeSubnetsResult',],
        ],
        'DescribeTags' => [
            'name' => 'DescribeTags',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeTagsRequest',],
            'output' => ['shape' => 'DescribeTagsResult',],
        ],
        'DescribeVolumeAttribute' => [
            'name' => 'DescribeVolumeAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVolumeAttributeRequest',],
            'output' => ['shape' => 'DescribeVolumeAttributeResult',],
        ],
        'DescribeVolumeStatus' => [
            'name' => 'DescribeVolumeStatus',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVolumeStatusRequest',],
            'output' => ['shape' => 'DescribeVolumeStatusResult',],
        ],
        'DescribeVolumes' => [
            'name' => 'DescribeVolumes',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVolumesRequest',],
            'output' => ['shape' => 'DescribeVolumesResult',],
        ],
        'DescribeVolumesModifications' => [
            'name' => 'DescribeVolumesModifications',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVolumesModificationsRequest',],
            'output' => ['shape' => 'DescribeVolumesModificationsResult',],
        ],
        'DescribeVpcAttribute' => [
            'name' => 'DescribeVpcAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcAttributeRequest',],
            'output' => ['shape' => 'DescribeVpcAttributeResult',],
        ],
        'DescribeVpcClassicLink' => [
            'name' => 'DescribeVpcClassicLink',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcClassicLinkRequest',],
            'output' => ['shape' => 'DescribeVpcClassicLinkResult',],
        ],
        'DescribeVpcClassicLinkDnsSupport' => [
            'name' => 'DescribeVpcClassicLinkDnsSupport',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcClassicLinkDnsSupportRequest',],
            'output' => ['shape' => 'DescribeVpcClassicLinkDnsSupportResult',],
        ],
        'DescribeVpcEndpointServices' => [
            'name' => 'DescribeVpcEndpointServices',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcEndpointServicesRequest',],
            'output' => ['shape' => 'DescribeVpcEndpointServicesResult',],
        ],
        'DescribeVpcEndpoints' => [
            'name' => 'DescribeVpcEndpoints',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcEndpointsRequest',],
            'output' => ['shape' => 'DescribeVpcEndpointsResult',],
        ],
        'DescribeVpcPeeringConnections' => [
            'name' => 'DescribeVpcPeeringConnections',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcPeeringConnectionsRequest',],
            'output' => ['shape' => 'DescribeVpcPeeringConnectionsResult',],
        ],
        'DescribeVpcs' => [
            'name' => 'DescribeVpcs',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpcsRequest',],
            'output' => ['shape' => 'DescribeVpcsResult',],
        ],
        'DescribeVpnConnections' => [
            'name' => 'DescribeVpnConnections',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpnConnectionsRequest',],
            'output' => ['shape' => 'DescribeVpnConnectionsResult',],
        ],
        'DescribeVpnGateways' => [
            'name' => 'DescribeVpnGateways',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DescribeVpnGatewaysRequest',],
            'output' => ['shape' => 'DescribeVpnGatewaysResult',],
        ],
        'DetachClassicLinkVpc' => [
            'name' => 'DetachClassicLinkVpc',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DetachClassicLinkVpcRequest',],
            'output' => ['shape' => 'DetachClassicLinkVpcResult',],
        ],
        'DetachInternetGateway' => [
            'name' => 'DetachInternetGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DetachInternetGatewayRequest',],
        ],
        'DetachNetworkInterface' => [
            'name' => 'DetachNetworkInterface',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DetachNetworkInterfaceRequest',],
        ],
        'DetachVolume' => [
            'name' => 'DetachVolume',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DetachVolumeRequest',],
            'output' => ['shape' => 'VolumeAttachment',],
        ],
        'DetachVpnGateway' => [
            'name' => 'DetachVpnGateway',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DetachVpnGatewayRequest',],
        ],
        'DisableVgwRoutePropagation' => [
            'name' => 'DisableVgwRoutePropagation',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisableVgwRoutePropagationRequest',],
        ],
        'DisableVpcClassicLink' => [
            'name' => 'DisableVpcClassicLink',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisableVpcClassicLinkRequest',],
            'output' => ['shape' => 'DisableVpcClassicLinkResult',],
        ],
        'DisableVpcClassicLinkDnsSupport' => [
            'name' => 'DisableVpcClassicLinkDnsSupport',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisableVpcClassicLinkDnsSupportRequest',],
            'output' => ['shape' => 'DisableVpcClassicLinkDnsSupportResult',],
        ],
        'DisassociateAddress' => [
            'name' => 'DisassociateAddress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisassociateAddressRequest',],
        ],
        'DisassociateIamInstanceProfile' => [
            'name' => 'DisassociateIamInstanceProfile',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisassociateIamInstanceProfileRequest',],
            'output' => ['shape' => 'DisassociateIamInstanceProfileResult',],
        ],
        'DisassociateRouteTable' => [
            'name' => 'DisassociateRouteTable',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisassociateRouteTableRequest',],
        ],
        'DisassociateSubnetCidrBlock' => [
            'name' => 'DisassociateSubnetCidrBlock',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisassociateSubnetCidrBlockRequest',],
            'output' => ['shape' => 'DisassociateSubnetCidrBlockResult',],
        ],
        'DisassociateVpcCidrBlock' => [
            'name' => 'DisassociateVpcCidrBlock',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'DisassociateVpcCidrBlockRequest',],
            'output' => ['shape' => 'DisassociateVpcCidrBlockResult',],
        ],
        'EnableVgwRoutePropagation' => [
            'name' => 'EnableVgwRoutePropagation',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'EnableVgwRoutePropagationRequest',],
        ],
        'EnableVolumeIO' => [
            'name' => 'EnableVolumeIO',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'EnableVolumeIORequest',],
        ],
        'EnableVpcClassicLink' => [
            'name' => 'EnableVpcClassicLink',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'EnableVpcClassicLinkRequest',],
            'output' => ['shape' => 'EnableVpcClassicLinkResult',],
        ],
        'EnableVpcClassicLinkDnsSupport' => [
            'name' => 'EnableVpcClassicLinkDnsSupport',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'EnableVpcClassicLinkDnsSupportRequest',],
            'output' => ['shape' => 'EnableVpcClassicLinkDnsSupportResult',],
        ],
        'GetConsoleOutput' => [
            'name' => 'GetConsoleOutput',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetConsoleOutputRequest',],
            'output' => ['shape' => 'GetConsoleOutputResult',],
        ],
        'GetConsoleScreenshot' => [
            'name' => 'GetConsoleScreenshot',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetConsoleScreenshotRequest',],
            'output' => ['shape' => 'GetConsoleScreenshotResult',],
        ],
        'GetHostReservationPurchasePreview' => [
            'name' => 'GetHostReservationPurchasePreview',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetHostReservationPurchasePreviewRequest',],
            'output' => ['shape' => 'GetHostReservationPurchasePreviewResult',],
        ],
        'GetPasswordData' => [
            'name' => 'GetPasswordData',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetPasswordDataRequest',],
            'output' => ['shape' => 'GetPasswordDataResult',],
        ],
        'GetReservedInstancesExchangeQuote' => [
            'name' => 'GetReservedInstancesExchangeQuote',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'GetReservedInstancesExchangeQuoteRequest',],
            'output' => ['shape' => 'GetReservedInstancesExchangeQuoteResult',],
        ],
        'ImportImage' => [
            'name' => 'ImportImage',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ImportImageRequest',],
            'output' => ['shape' => 'ImportImageResult',],
        ],
        'ImportInstance' => [
            'name' => 'ImportInstance',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ImportInstanceRequest',],
            'output' => ['shape' => 'ImportInstanceResult',],
        ],
        'ImportKeyPair' => [
            'name' => 'ImportKeyPair',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ImportKeyPairRequest',],
            'output' => ['shape' => 'ImportKeyPairResult',],
        ],
        'ImportSnapshot' => [
            'name' => 'ImportSnapshot',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ImportSnapshotRequest',],
            'output' => ['shape' => 'ImportSnapshotResult',],
        ],
        'ImportVolume' => [
            'name' => 'ImportVolume',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ImportVolumeRequest',],
            'output' => ['shape' => 'ImportVolumeResult',],
        ],
        'ModifyHosts' => [
            'name' => 'ModifyHosts',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyHostsRequest',],
            'output' => ['shape' => 'ModifyHostsResult',],
        ],
        'ModifyIdFormat' => [
            'name' => 'ModifyIdFormat',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyIdFormatRequest',],
        ],
        'ModifyIdentityIdFormat' => [
            'name' => 'ModifyIdentityIdFormat',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyIdentityIdFormatRequest',],
        ],
        'ModifyImageAttribute' => [
            'name' => 'ModifyImageAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyImageAttributeRequest',],
        ],
        'ModifyInstanceAttribute' => [
            'name' => 'ModifyInstanceAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyInstanceAttributeRequest',],
        ],
        'ModifyInstancePlacement' => [
            'name' => 'ModifyInstancePlacement',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyInstancePlacementRequest',],
            'output' => ['shape' => 'ModifyInstancePlacementResult',],
        ],
        'ModifyNetworkInterfaceAttribute' => [
            'name' => 'ModifyNetworkInterfaceAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyNetworkInterfaceAttributeRequest',],
        ],
        'ModifyReservedInstances' => [
            'name' => 'ModifyReservedInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyReservedInstancesRequest',],
            'output' => ['shape' => 'ModifyReservedInstancesResult',],
        ],
        'ModifySnapshotAttribute' => [
            'name' => 'ModifySnapshotAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifySnapshotAttributeRequest',],
        ],
        'ModifySpotFleetRequest' => [
            'name' => 'ModifySpotFleetRequest',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifySpotFleetRequestRequest',],
            'output' => ['shape' => 'ModifySpotFleetRequestResponse',],
        ],
        'ModifySubnetAttribute' => [
            'name' => 'ModifySubnetAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifySubnetAttributeRequest',],
        ],
        'ModifyVolume' => [
            'name' => 'ModifyVolume',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyVolumeRequest',],
            'output' => ['shape' => 'ModifyVolumeResult',],
        ],
        'ModifyVolumeAttribute' => [
            'name' => 'ModifyVolumeAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyVolumeAttributeRequest',],
        ],
        'ModifyVpcAttribute' => [
            'name' => 'ModifyVpcAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyVpcAttributeRequest',],
        ],
        'ModifyVpcEndpoint' => [
            'name' => 'ModifyVpcEndpoint',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyVpcEndpointRequest',],
            'output' => ['shape' => 'ModifyVpcEndpointResult',],
        ],
        'ModifyVpcPeeringConnectionOptions' => [
            'name' => 'ModifyVpcPeeringConnectionOptions',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ModifyVpcPeeringConnectionOptionsRequest',],
            'output' => ['shape' => 'ModifyVpcPeeringConnectionOptionsResult',],
        ],
        'MonitorInstances' => [
            'name' => 'MonitorInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'MonitorInstancesRequest',],
            'output' => ['shape' => 'MonitorInstancesResult',],
        ],
        'MoveAddressToVpc' => [
            'name' => 'MoveAddressToVpc',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'MoveAddressToVpcRequest',],
            'output' => ['shape' => 'MoveAddressToVpcResult',],
        ],
        'PurchaseHostReservation' => [
            'name' => 'PurchaseHostReservation',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'PurchaseHostReservationRequest',],
            'output' => ['shape' => 'PurchaseHostReservationResult',],
        ],
        'PurchaseReservedInstancesOffering' => [
            'name' => 'PurchaseReservedInstancesOffering',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'PurchaseReservedInstancesOfferingRequest',],
            'output' => ['shape' => 'PurchaseReservedInstancesOfferingResult',],
        ],
        'PurchaseScheduledInstances' => [
            'name' => 'PurchaseScheduledInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'PurchaseScheduledInstancesRequest',],
            'output' => ['shape' => 'PurchaseScheduledInstancesResult',],
        ],
        'RebootInstances' => [
            'name' => 'RebootInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RebootInstancesRequest',],
        ],
        'RegisterImage' => [
            'name' => 'RegisterImage',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RegisterImageRequest',],
            'output' => ['shape' => 'RegisterImageResult',],
        ],
        'RejectVpcPeeringConnection' => [
            'name' => 'RejectVpcPeeringConnection',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RejectVpcPeeringConnectionRequest',],
            'output' => ['shape' => 'RejectVpcPeeringConnectionResult',],
        ],
        'ReleaseAddress' => [
            'name' => 'ReleaseAddress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReleaseAddressRequest',],
        ],
        'ReleaseHosts' => [
            'name' => 'ReleaseHosts',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReleaseHostsRequest',],
            'output' => ['shape' => 'ReleaseHostsResult',],
        ],
        'ReplaceIamInstanceProfileAssociation' => [
            'name' => 'ReplaceIamInstanceProfileAssociation',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReplaceIamInstanceProfileAssociationRequest',],
            'output' => ['shape' => 'ReplaceIamInstanceProfileAssociationResult',],
        ],
        'ReplaceNetworkAclAssociation' => [
            'name' => 'ReplaceNetworkAclAssociation',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReplaceNetworkAclAssociationRequest',],
            'output' => ['shape' => 'ReplaceNetworkAclAssociationResult',],
        ],
        'ReplaceNetworkAclEntry' => [
            'name' => 'ReplaceNetworkAclEntry',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReplaceNetworkAclEntryRequest',],
        ],
        'ReplaceRoute' => [
            'name' => 'ReplaceRoute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReplaceRouteRequest',],
        ],
        'ReplaceRouteTableAssociation' => [
            'name' => 'ReplaceRouteTableAssociation',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReplaceRouteTableAssociationRequest',],
            'output' => ['shape' => 'ReplaceRouteTableAssociationResult',],
        ],
        'ReportInstanceStatus' => [
            'name' => 'ReportInstanceStatus',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ReportInstanceStatusRequest',],
        ],
        'RequestSpotFleet' => [
            'name' => 'RequestSpotFleet',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RequestSpotFleetRequest',],
            'output' => ['shape' => 'RequestSpotFleetResponse',],
        ],
        'RequestSpotInstances' => [
            'name' => 'RequestSpotInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RequestSpotInstancesRequest',],
            'output' => ['shape' => 'RequestSpotInstancesResult',],
        ],
        'ResetImageAttribute' => [
            'name' => 'ResetImageAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ResetImageAttributeRequest',],
        ],
        'ResetInstanceAttribute' => [
            'name' => 'ResetInstanceAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ResetInstanceAttributeRequest',],
        ],
        'ResetNetworkInterfaceAttribute' => [
            'name' => 'ResetNetworkInterfaceAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ResetNetworkInterfaceAttributeRequest',],
        ],
        'ResetSnapshotAttribute' => [
            'name' => 'ResetSnapshotAttribute',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'ResetSnapshotAttributeRequest',],
        ],
        'RestoreAddressToClassic' => [
            'name' => 'RestoreAddressToClassic',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RestoreAddressToClassicRequest',],
            'output' => ['shape' => 'RestoreAddressToClassicResult',],
        ],
        'RevokeSecurityGroupEgress' => [
            'name' => 'RevokeSecurityGroupEgress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RevokeSecurityGroupEgressRequest',],
        ],
        'RevokeSecurityGroupIngress' => [
            'name' => 'RevokeSecurityGroupIngress',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RevokeSecurityGroupIngressRequest',],
        ],
        'RunInstances' => [
            'name' => 'RunInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RunInstancesRequest',],
            'output' => ['shape' => 'Reservation',],
        ],
        'RunScheduledInstances' => [
            'name' => 'RunScheduledInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'RunScheduledInstancesRequest',],
            'output' => ['shape' => 'RunScheduledInstancesResult',],
        ],
        'StartInstances' => [
            'name' => 'StartInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'StartInstancesRequest',],
            'output' => ['shape' => 'StartInstancesResult',],
        ],
        'StopInstances' => [
            'name' => 'StopInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'StopInstancesRequest',],
            'output' => ['shape' => 'StopInstancesResult',],
        ],
        'TerminateInstances' => [
            'name' => 'TerminateInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'TerminateInstancesRequest',],
            'output' => ['shape' => 'TerminateInstancesResult',],
        ],
        'UnassignIpv6Addresses' => [
            'name' => 'UnassignIpv6Addresses',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UnassignIpv6AddressesRequest',],
            'output' => ['shape' => 'UnassignIpv6AddressesResult',],
        ],
        'UnassignPrivateIpAddresses' => [
            'name' => 'UnassignPrivateIpAddresses',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UnassignPrivateIpAddressesRequest',],
        ],
        'UnmonitorInstances' => [
            'name' => 'UnmonitorInstances',
            'http' => ['method' => 'POST', 'requestUri' => '/',],
            'input' => ['shape' => 'UnmonitorInstancesRequest',],
            'output' => ['shape' => 'UnmonitorInstancesResult',],
        ],
    ],
    'shapes' => [
        'AcceptReservedInstancesExchangeQuoteRequest' => [
            'type' => 'structure',
            'required' => ['ReservedInstanceIds',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'ReservedInstanceIds' => ['shape' => 'ReservedInstanceIdSet', 'locationName' => 'ReservedInstanceId',],
                'TargetConfigurations' => [
                    'shape' => 'TargetConfigurationRequestSet',
                    'locationName' => 'TargetConfiguration',
                ],
            ],
        ],
        'AcceptReservedInstancesExchangeQuoteResult' => [
            'type' => 'structure',
            'members' => ['ExchangeId' => ['shape' => 'String', 'locationName' => 'exchangeId',],],
        ],
        'AcceptVpcPeeringConnectionRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'AcceptVpcPeeringConnectionResult' => [
            'type' => 'structure',
            'members' => [
                'VpcPeeringConnection' => [
                    'shape' => 'VpcPeeringConnection',
                    'locationName' => 'vpcPeeringConnection',
                ],
            ],
        ],
        'AccountAttribute' => [
            'type' => 'structure',
            'members' => [
                'AttributeName' => ['shape' => 'String', 'locationName' => 'attributeName',],
                'AttributeValues' => ['shape' => 'AccountAttributeValueList', 'locationName' => 'attributeValueSet',],
            ],
        ],
        'AccountAttributeList' => [
            'type' => 'list',
            'member' => ['shape' => 'AccountAttribute', 'locationName' => 'item',],
        ],
        'AccountAttributeName' => ['type' => 'string', 'enum' => ['supported-platforms', 'default-vpc',],],
        'AccountAttributeNameStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'AccountAttributeName', 'locationName' => 'attributeName',],
        ],
        'AccountAttributeValue' => [
            'type' => 'structure',
            'members' => ['AttributeValue' => ['shape' => 'String', 'locationName' => 'attributeValue',],],
        ],
        'AccountAttributeValueList' => [
            'type' => 'list',
            'member' => ['shape' => 'AccountAttributeValue', 'locationName' => 'item',],
        ],
        'ActiveInstance' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
                'SpotInstanceRequestId' => ['shape' => 'String', 'locationName' => 'spotInstanceRequestId',],
                'InstanceHealth' => ['shape' => 'InstanceHealthStatus', 'locationName' => 'instanceHealth',],
            ],
        ],
        'ActiveInstanceSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ActiveInstance', 'locationName' => 'item',],
        ],
        'ActivityStatus' => [
            'type' => 'string',
            'enum' => ['error', 'pending_fulfillment', 'pending_termination', 'fulfilled',],
        ],
        'Address' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
                'AllocationId' => ['shape' => 'String', 'locationName' => 'allocationId',],
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'Domain' => ['shape' => 'DomainType', 'locationName' => 'domain',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'NetworkInterfaceOwnerId' => ['shape' => 'String', 'locationName' => 'networkInterfaceOwnerId',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
            ],
        ],
        'AddressList' => ['type' => 'list', 'member' => ['shape' => 'Address', 'locationName' => 'item',],],
        'Affinity' => ['type' => 'string', 'enum' => ['default', 'host',],],
        'AllocateAddressRequest' => [
            'type' => 'structure',
            'members' => [
                'Domain' => ['shape' => 'DomainType',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'AllocateAddressResult' => [
            'type' => 'structure',
            'members' => [
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
                'AllocationId' => ['shape' => 'String', 'locationName' => 'allocationId',],
                'Domain' => ['shape' => 'DomainType', 'locationName' => 'domain',],
            ],
        ],
        'AllocateHostsRequest' => [
            'type' => 'structure',
            'required' => ['AvailabilityZone', 'InstanceType', 'Quantity',],
            'members' => [
                'AutoPlacement' => ['shape' => 'AutoPlacement', 'locationName' => 'autoPlacement',],
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
                'Quantity' => ['shape' => 'Integer', 'locationName' => 'quantity',],
            ],
        ],
        'AllocateHostsResult' => [
            'type' => 'structure',
            'members' => ['HostIds' => ['shape' => 'ResponseHostIdList', 'locationName' => 'hostIdSet',],],
        ],
        'AllocationIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'AllocationId',],],
        'AllocationState' => [
            'type' => 'string',
            'enum' => ['available', 'under-assessment', 'permanent-failure', 'released', 'released-permanent-failure',],
        ],
        'AllocationStrategy' => ['type' => 'string', 'enum' => ['lowestPrice', 'diversified',],],
        'ArchitectureValues' => ['type' => 'string', 'enum' => ['i386', 'x86_64',],],
        'AssignIpv6AddressesRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId',],
            'members' => [
                'Ipv6AddressCount' => ['shape' => 'Integer', 'locationName' => 'ipv6AddressCount',],
                'Ipv6Addresses' => ['shape' => 'Ipv6AddressList', 'locationName' => 'ipv6Addresses',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
            ],
        ],
        'AssignIpv6AddressesResult' => [
            'type' => 'structure',
            'members' => [
                'AssignedIpv6Addresses' => [
                    'shape' => 'Ipv6AddressList',
                    'locationName' => 'assignedIpv6Addresses',
                ],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
            ],
        ],
        'AssignPrivateIpAddressesRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId',],
            'members' => [
                'AllowReassignment' => ['shape' => 'Boolean', 'locationName' => 'allowReassignment',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'PrivateIpAddresses' => [
                    'shape' => 'PrivateIpAddressStringList',
                    'locationName' => 'privateIpAddress',
                ],
                'SecondaryPrivateIpAddressCount' => [
                    'shape' => 'Integer',
                    'locationName' => 'secondaryPrivateIpAddressCount',
                ],
            ],
        ],
        'AssociateAddressRequest' => [
            'type' => 'structure',
            'members' => [
                'AllocationId' => ['shape' => 'String',],
                'InstanceId' => ['shape' => 'String',],
                'PublicIp' => ['shape' => 'String',],
                'AllowReassociation' => ['shape' => 'Boolean', 'locationName' => 'allowReassociation',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
            ],
        ],
        'AssociateAddressResult' => [
            'type' => 'structure',
            'members' => ['AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],],
        ],
        'AssociateDhcpOptionsRequest' => [
            'type' => 'structure',
            'required' => ['DhcpOptionsId', 'VpcId',],
            'members' => [
                'DhcpOptionsId' => ['shape' => 'String',],
                'VpcId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'AssociateIamInstanceProfileRequest' => [
            'type' => 'structure',
            'required' => ['IamInstanceProfile', 'InstanceId',],
            'members' => [
                'IamInstanceProfile' => ['shape' => 'IamInstanceProfileSpecification',],
                'InstanceId' => ['shape' => 'String',],
            ],
        ],
        'AssociateIamInstanceProfileResult' => [
            'type' => 'structure',
            'members' => [
                'IamInstanceProfileAssociation' => [
                    'shape' => 'IamInstanceProfileAssociation',
                    'locationName' => 'iamInstanceProfileAssociation',
                ],
            ],
        ],
        'AssociateRouteTableRequest' => [
            'type' => 'structure',
            'required' => ['RouteTableId', 'SubnetId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'AssociateRouteTableResult' => [
            'type' => 'structure',
            'members' => ['AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],],
        ],
        'AssociateSubnetCidrBlockRequest' => [
            'type' => 'structure',
            'required' => ['Ipv6CidrBlock', 'SubnetId',],
            'members' => [
                'Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'AssociateSubnetCidrBlockResult' => [
            'type' => 'structure',
            'members' => [
                'Ipv6CidrBlockAssociation' => [
                    'shape' => 'SubnetIpv6CidrBlockAssociation',
                    'locationName' => 'ipv6CidrBlockAssociation',
                ],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'AssociateVpcCidrBlockRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'AmazonProvidedIpv6CidrBlock' => [
                    'shape' => 'Boolean',
                    'locationName' => 'amazonProvidedIpv6CidrBlock',
                ],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'AssociateVpcCidrBlockResult' => [
            'type' => 'structure',
            'members' => [
                'Ipv6CidrBlockAssociation' => [
                    'shape' => 'VpcIpv6CidrBlockAssociation',
                    'locationName' => 'ipv6CidrBlockAssociation',
                ],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'AssociationIdList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'AssociationId',],
        ],
        'AttachClassicLinkVpcRequest' => [
            'type' => 'structure',
            'required' => ['Groups', 'InstanceId', 'VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Groups' => ['shape' => 'GroupIdStringList', 'locationName' => 'SecurityGroupId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'AttachClassicLinkVpcResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'AttachInternetGatewayRequest' => [
            'type' => 'structure',
            'required' => ['InternetGatewayId', 'VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InternetGatewayId' => ['shape' => 'String', 'locationName' => 'internetGatewayId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'AttachNetworkInterfaceRequest' => [
            'type' => 'structure',
            'required' => ['DeviceIndex', 'InstanceId', 'NetworkInterfaceId',],
            'members' => [
                'DeviceIndex' => ['shape' => 'Integer', 'locationName' => 'deviceIndex',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
            ],
        ],
        'AttachNetworkInterfaceResult' => [
            'type' => 'structure',
            'members' => ['AttachmentId' => ['shape' => 'String', 'locationName' => 'attachmentId',],],
        ],
        'AttachVolumeRequest' => [
            'type' => 'structure',
            'required' => ['Device', 'InstanceId', 'VolumeId',],
            'members' => [
                'Device' => ['shape' => 'String',],
                'InstanceId' => ['shape' => 'String',],
                'VolumeId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'AttachVpnGatewayRequest' => [
            'type' => 'structure',
            'required' => ['VpcId', 'VpnGatewayId',],
            'members' => [
                'VpcId' => ['shape' => 'String',],
                'VpnGatewayId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'AttachVpnGatewayResult' => [
            'type' => 'structure',
            'members' => ['VpcAttachment' => ['shape' => 'VpcAttachment', 'locationName' => 'attachment',],],
        ],
        'AttachmentStatus' => ['type' => 'string', 'enum' => ['attaching', 'attached', 'detaching', 'detached',],],
        'AttributeBooleanValue' => [
            'type' => 'structure',
            'members' => ['Value' => ['shape' => 'Boolean', 'locationName' => 'value',],],
        ],
        'AttributeValue' => [
            'type' => 'structure',
            'members' => ['Value' => ['shape' => 'String', 'locationName' => 'value',],],
        ],
        'AuthorizeSecurityGroupEgressRequest' => [
            'type' => 'structure',
            'required' => ['GroupId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
                'IpPermissions' => ['shape' => 'IpPermissionList', 'locationName' => 'ipPermissions',],
                'CidrIp' => ['shape' => 'String', 'locationName' => 'cidrIp',],
                'FromPort' => ['shape' => 'Integer', 'locationName' => 'fromPort',],
                'IpProtocol' => ['shape' => 'String', 'locationName' => 'ipProtocol',],
                'ToPort' => ['shape' => 'Integer', 'locationName' => 'toPort',],
                'SourceSecurityGroupName' => ['shape' => 'String', 'locationName' => 'sourceSecurityGroupName',],
                'SourceSecurityGroupOwnerId' => ['shape' => 'String', 'locationName' => 'sourceSecurityGroupOwnerId',],
            ],
        ],
        'AuthorizeSecurityGroupIngressRequest' => [
            'type' => 'structure',
            'members' => [
                'CidrIp' => ['shape' => 'String',],
                'FromPort' => ['shape' => 'Integer',],
                'GroupId' => ['shape' => 'String',],
                'GroupName' => ['shape' => 'String',],
                'IpPermissions' => ['shape' => 'IpPermissionList',],
                'IpProtocol' => ['shape' => 'String',],
                'SourceSecurityGroupName' => ['shape' => 'String',],
                'SourceSecurityGroupOwnerId' => ['shape' => 'String',],
                'ToPort' => ['shape' => 'Integer',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'AutoPlacement' => ['type' => 'string', 'enum' => ['on', 'off',],],
        'AvailabilityZone' => [
            'type' => 'structure',
            'members' => [
                'State' => ['shape' => 'AvailabilityZoneState', 'locationName' => 'zoneState',],
                'Messages' => ['shape' => 'AvailabilityZoneMessageList', 'locationName' => 'messageSet',],
                'RegionName' => ['shape' => 'String', 'locationName' => 'regionName',],
                'ZoneName' => ['shape' => 'String', 'locationName' => 'zoneName',],
            ],
        ],
        'AvailabilityZoneList' => [
            'type' => 'list',
            'member' => ['shape' => 'AvailabilityZone', 'locationName' => 'item',],
        ],
        'AvailabilityZoneMessage' => [
            'type' => 'structure',
            'members' => ['Message' => ['shape' => 'String', 'locationName' => 'message',],],
        ],
        'AvailabilityZoneMessageList' => [
            'type' => 'list',
            'member' => ['shape' => 'AvailabilityZoneMessage', 'locationName' => 'item',],
        ],
        'AvailabilityZoneState' => [
            'type' => 'string',
            'enum' => ['available', 'information', 'impaired', 'unavailable',],
        ],
        'AvailableCapacity' => [
            'type' => 'structure',
            'members' => [
                'AvailableInstanceCapacity' => [
                    'shape' => 'AvailableInstanceCapacityList',
                    'locationName' => 'availableInstanceCapacity',
                ],
                'AvailableVCpus' => ['shape' => 'Integer', 'locationName' => 'availableVCpus',],
            ],
        ],
        'AvailableInstanceCapacityList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceCapacity', 'locationName' => 'item',],
        ],
        'BatchState' => [
            'type' => 'string',
            'enum' => [
                'submitted',
                'active',
                'cancelled',
                'failed',
                'cancelled_running',
                'cancelled_terminating',
                'modifying',
            ],
        ],
        'BillingProductList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'Blob' => ['type' => 'blob',],
        'BlobAttributeValue' => [
            'type' => 'structure',
            'members' => ['Value' => ['shape' => 'Blob', 'locationName' => 'value',],],
        ],
        'BlockDeviceMapping' => [
            'type' => 'structure',
            'members' => [
                'DeviceName' => ['shape' => 'String', 'locationName' => 'deviceName',],
                'VirtualName' => ['shape' => 'String', 'locationName' => 'virtualName',],
                'Ebs' => ['shape' => 'EbsBlockDevice', 'locationName' => 'ebs',],
                'NoDevice' => ['shape' => 'String', 'locationName' => 'noDevice',],
            ],
        ],
        'BlockDeviceMappingList' => [
            'type' => 'list',
            'member' => ['shape' => 'BlockDeviceMapping', 'locationName' => 'item',],
        ],
        'BlockDeviceMappingRequestList' => [
            'type' => 'list',
            'member' => ['shape' => 'BlockDeviceMapping', 'locationName' => 'BlockDeviceMapping',],
        ],
        'Boolean' => ['type' => 'boolean',],
        'BundleIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'BundleId',],],
        'BundleInstanceRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId', 'Storage',],
            'members' => [
                'InstanceId' => ['shape' => 'String',],
                'Storage' => ['shape' => 'Storage',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'BundleInstanceResult' => [
            'type' => 'structure',
            'members' => ['BundleTask' => ['shape' => 'BundleTask', 'locationName' => 'bundleInstanceTask',],],
        ],
        'BundleTask' => [
            'type' => 'structure',
            'members' => [
                'BundleId' => ['shape' => 'String', 'locationName' => 'bundleId',],
                'BundleTaskError' => ['shape' => 'BundleTaskError', 'locationName' => 'error',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Progress' => ['shape' => 'String', 'locationName' => 'progress',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
                'State' => ['shape' => 'BundleTaskState', 'locationName' => 'state',],
                'Storage' => ['shape' => 'Storage', 'locationName' => 'storage',],
                'UpdateTime' => ['shape' => 'DateTime', 'locationName' => 'updateTime',],
            ],
        ],
        'BundleTaskError' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'String', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'BundleTaskList' => ['type' => 'list', 'member' => ['shape' => 'BundleTask', 'locationName' => 'item',],],
        'BundleTaskState' => [
            'type' => 'string',
            'enum' => ['pending', 'waiting-for-shutdown', 'bundling', 'storing', 'cancelling', 'complete', 'failed',],
        ],
        'CancelBatchErrorCode' => [
            'type' => 'string',
            'enum' => [
                'fleetRequestIdDoesNotExist',
                'fleetRequestIdMalformed',
                'fleetRequestNotInCancellableState',
                'unexpectedError',
            ],
        ],
        'CancelBundleTaskRequest' => [
            'type' => 'structure',
            'required' => ['BundleId',],
            'members' => [
                'BundleId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CancelBundleTaskResult' => [
            'type' => 'structure',
            'members' => ['BundleTask' => ['shape' => 'BundleTask', 'locationName' => 'bundleInstanceTask',],],
        ],
        'CancelConversionRequest' => [
            'type' => 'structure',
            'required' => ['ConversionTaskId',],
            'members' => [
                'ConversionTaskId' => ['shape' => 'String', 'locationName' => 'conversionTaskId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'ReasonMessage' => ['shape' => 'String', 'locationName' => 'reasonMessage',],
            ],
        ],
        'CancelExportTaskRequest' => [
            'type' => 'structure',
            'required' => ['ExportTaskId',],
            'members' => ['ExportTaskId' => ['shape' => 'String', 'locationName' => 'exportTaskId',],],
        ],
        'CancelImportTaskRequest' => [
            'type' => 'structure',
            'members' => [
                'CancelReason' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean',],
                'ImportTaskId' => ['shape' => 'String',],
            ],
        ],
        'CancelImportTaskResult' => [
            'type' => 'structure',
            'members' => [
                'ImportTaskId' => ['shape' => 'String', 'locationName' => 'importTaskId',],
                'PreviousState' => ['shape' => 'String', 'locationName' => 'previousState',],
                'State' => ['shape' => 'String', 'locationName' => 'state',],
            ],
        ],
        'CancelReservedInstancesListingRequest' => [
            'type' => 'structure',
            'required' => ['ReservedInstancesListingId',],
            'members' => [
                'ReservedInstancesListingId' => [
                    'shape' => 'String',
                    'locationName' => 'reservedInstancesListingId',
                ],
            ],
        ],
        'CancelReservedInstancesListingResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstancesListings' => [
                    'shape' => 'ReservedInstancesListingList',
                    'locationName' => 'reservedInstancesListingsSet',
                ],
            ],
        ],
        'CancelSpotFleetRequestsError' => [
            'type' => 'structure',
            'required' => ['Code', 'Message',],
            'members' => [
                'Code' => ['shape' => 'CancelBatchErrorCode', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'CancelSpotFleetRequestsErrorItem' => [
            'type' => 'structure',
            'required' => ['Error', 'SpotFleetRequestId',],
            'members' => [
                'Error' => ['shape' => 'CancelSpotFleetRequestsError', 'locationName' => 'error',],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
            ],
        ],
        'CancelSpotFleetRequestsErrorSet' => [
            'type' => 'list',
            'member' => ['shape' => 'CancelSpotFleetRequestsErrorItem', 'locationName' => 'item',],
        ],
        'CancelSpotFleetRequestsRequest' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestIds', 'TerminateInstances',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'SpotFleetRequestIds' => ['shape' => 'ValueStringList', 'locationName' => 'spotFleetRequestId',],
                'TerminateInstances' => ['shape' => 'Boolean', 'locationName' => 'terminateInstances',],
            ],
        ],
        'CancelSpotFleetRequestsResponse' => [
            'type' => 'structure',
            'members' => [
                'SuccessfulFleetRequests' => [
                    'shape' => 'CancelSpotFleetRequestsSuccessSet',
                    'locationName' => 'successfulFleetRequestSet',
                ],
                'UnsuccessfulFleetRequests' => [
                    'shape' => 'CancelSpotFleetRequestsErrorSet',
                    'locationName' => 'unsuccessfulFleetRequestSet',
                ],
            ],
        ],
        'CancelSpotFleetRequestsSuccessItem' => [
            'type' => 'structure',
            'required' => ['CurrentSpotFleetRequestState', 'PreviousSpotFleetRequestState', 'SpotFleetRequestId',],
            'members' => [
                'CurrentSpotFleetRequestState' => [
                    'shape' => 'BatchState',
                    'locationName' => 'currentSpotFleetRequestState',
                ],
                'PreviousSpotFleetRequestState' => [
                    'shape' => 'BatchState',
                    'locationName' => 'previousSpotFleetRequestState',
                ],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
            ],
        ],
        'CancelSpotFleetRequestsSuccessSet' => [
            'type' => 'list',
            'member' => ['shape' => 'CancelSpotFleetRequestsSuccessItem', 'locationName' => 'item',],
        ],
        'CancelSpotInstanceRequestState' => [
            'type' => 'string',
            'enum' => ['active', 'open', 'closed', 'cancelled', 'completed',],
        ],
        'CancelSpotInstanceRequestsRequest' => [
            'type' => 'structure',
            'required' => ['SpotInstanceRequestIds',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'SpotInstanceRequestIds' => [
                    'shape' => 'SpotInstanceRequestIdList',
                    'locationName' => 'SpotInstanceRequestId',
                ],
            ],
        ],
        'CancelSpotInstanceRequestsResult' => [
            'type' => 'structure',
            'members' => [
                'CancelledSpotInstanceRequests' => [
                    'shape' => 'CancelledSpotInstanceRequestList',
                    'locationName' => 'spotInstanceRequestSet',
                ],
            ],
        ],
        'CancelledSpotInstanceRequest' => [
            'type' => 'structure',
            'members' => [
                'SpotInstanceRequestId' => ['shape' => 'String', 'locationName' => 'spotInstanceRequestId',],
                'State' => ['shape' => 'CancelSpotInstanceRequestState', 'locationName' => 'state',],
            ],
        ],
        'CancelledSpotInstanceRequestList' => [
            'type' => 'list',
            'member' => ['shape' => 'CancelledSpotInstanceRequest', 'locationName' => 'item',],
        ],
        'ClassicLinkDnsSupport' => [
            'type' => 'structure',
            'members' => [
                'ClassicLinkDnsSupported' => [
                    'shape' => 'Boolean',
                    'locationName' => 'classicLinkDnsSupported',
                ],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'ClassicLinkDnsSupportList' => [
            'type' => 'list',
            'member' => ['shape' => 'ClassicLinkDnsSupport', 'locationName' => 'item',],
        ],
        'ClassicLinkInstance' => [
            'type' => 'structure',
            'members' => [
                'Groups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'ClassicLinkInstanceList' => [
            'type' => 'list',
            'member' => ['shape' => 'ClassicLinkInstance', 'locationName' => 'item',],
        ],
        'ClientData' => [
            'type' => 'structure',
            'members' => [
                'Comment' => ['shape' => 'String',],
                'UploadEnd' => ['shape' => 'DateTime',],
                'UploadSize' => ['shape' => 'Double',],
                'UploadStart' => ['shape' => 'DateTime',],
            ],
        ],
        'ConfirmProductInstanceRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId', 'ProductCode',],
            'members' => [
                'InstanceId' => ['shape' => 'String',],
                'ProductCode' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ConfirmProductInstanceResult' => [
            'type' => 'structure',
            'members' => [
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'Return' => ['shape' => 'Boolean', 'locationName' => 'return',],
            ],
        ],
        'ContainerFormat' => ['type' => 'string', 'enum' => ['ova',],],
        'ConversionIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'ConversionTask' => [
            'type' => 'structure',
            'required' => ['ConversionTaskId', 'State',],
            'members' => [
                'ConversionTaskId' => ['shape' => 'String', 'locationName' => 'conversionTaskId',],
                'ExpirationTime' => ['shape' => 'String', 'locationName' => 'expirationTime',],
                'ImportInstance' => ['shape' => 'ImportInstanceTaskDetails', 'locationName' => 'importInstance',],
                'ImportVolume' => ['shape' => 'ImportVolumeTaskDetails', 'locationName' => 'importVolume',],
                'State' => ['shape' => 'ConversionTaskState', 'locationName' => 'state',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'ConversionTaskState' => ['type' => 'string', 'enum' => ['active', 'cancelling', 'cancelled', 'completed',],],
        'CopyImageRequest' => [
            'type' => 'structure',
            'required' => ['Name', 'SourceImageId', 'SourceRegion',],
            'members' => [
                'ClientToken' => ['shape' => 'String',],
                'Description' => ['shape' => 'String',],
                'Encrypted' => ['shape' => 'Boolean', 'locationName' => 'encrypted',],
                'KmsKeyId' => ['shape' => 'String', 'locationName' => 'kmsKeyId',],
                'Name' => ['shape' => 'String',],
                'SourceImageId' => ['shape' => 'String',],
                'SourceRegion' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CopyImageResult' => [
            'type' => 'structure',
            'members' => ['ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],],
        ],
        'CopySnapshotRequest' => [
            'type' => 'structure',
            'required' => ['SourceRegion', 'SourceSnapshotId',],
            'members' => [
                'Description' => ['shape' => 'String',],
                'DestinationRegion' => ['shape' => 'String', 'locationName' => 'destinationRegion',],
                'Encrypted' => ['shape' => 'Boolean', 'locationName' => 'encrypted',],
                'KmsKeyId' => ['shape' => 'String', 'locationName' => 'kmsKeyId',],
                'PresignedUrl' => ['shape' => 'String', 'locationName' => 'presignedUrl',],
                'SourceRegion' => ['shape' => 'String',],
                'SourceSnapshotId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CopySnapshotResult' => [
            'type' => 'structure',
            'members' => ['SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],],
        ],
        'CreateCustomerGatewayRequest' => [
            'type' => 'structure',
            'required' => ['BgpAsn', 'PublicIp', 'Type',],
            'members' => [
                'BgpAsn' => ['shape' => 'Integer',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'IpAddress',],
                'Type' => ['shape' => 'GatewayType',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateCustomerGatewayResult' => [
            'type' => 'structure',
            'members' => ['CustomerGateway' => ['shape' => 'CustomerGateway', 'locationName' => 'customerGateway',],],
        ],
        'CreateDhcpOptionsRequest' => [
            'type' => 'structure',
            'required' => ['DhcpConfigurations',],
            'members' => [
                'DhcpConfigurations' => [
                    'shape' => 'NewDhcpConfigurationList',
                    'locationName' => 'dhcpConfiguration',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateDhcpOptionsResult' => [
            'type' => 'structure',
            'members' => ['DhcpOptions' => ['shape' => 'DhcpOptions', 'locationName' => 'dhcpOptions',],],
        ],
        'CreateEgressOnlyInternetGatewayRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'ClientToken' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean',],
                'VpcId' => ['shape' => 'String',],
            ],
        ],
        'CreateEgressOnlyInternetGatewayResult' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'EgressOnlyInternetGateway' => [
                    'shape' => 'EgressOnlyInternetGateway',
                    'locationName' => 'egressOnlyInternetGateway',
                ],
            ],
        ],
        'CreateFlowLogsRequest' => [
            'type' => 'structure',
            'required' => ['DeliverLogsPermissionArn', 'LogGroupName', 'ResourceIds', 'ResourceType', 'TrafficType',],
            'members' => [
                'ClientToken' => ['shape' => 'String',],
                'DeliverLogsPermissionArn' => ['shape' => 'String',],
                'LogGroupName' => ['shape' => 'String',],
                'ResourceIds' => ['shape' => 'ValueStringList', 'locationName' => 'ResourceId',],
                'ResourceType' => ['shape' => 'FlowLogsResourceType',],
                'TrafficType' => ['shape' => 'TrafficType',],
            ],
        ],
        'CreateFlowLogsResult' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'FlowLogIds' => ['shape' => 'ValueStringList', 'locationName' => 'flowLogIdSet',],
                'Unsuccessful' => ['shape' => 'UnsuccessfulItemSet', 'locationName' => 'unsuccessful',],
            ],
        ],
        'CreateFpgaImageRequest' => [
            'type' => 'structure',
            'required' => ['InputStorageLocation',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'InputStorageLocation' => ['shape' => 'StorageLocation',],
                'LogsStorageLocation' => ['shape' => 'StorageLocation',],
                'Description' => ['shape' => 'String',],
                'Name' => ['shape' => 'String',],
                'ClientToken' => ['shape' => 'String',],
            ],
        ],
        'CreateFpgaImageResult' => [
            'type' => 'structure',
            'members' => [
                'FpgaImageId' => ['shape' => 'String', 'locationName' => 'fpgaImageId',],
                'FpgaImageGlobalId' => ['shape' => 'String', 'locationName' => 'fpgaImageGlobalId',],
            ],
        ],
        'CreateImageRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId', 'Name',],
            'members' => [
                'BlockDeviceMappings' => [
                    'shape' => 'BlockDeviceMappingRequestList',
                    'locationName' => 'blockDeviceMapping',
                ],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Name' => ['shape' => 'String', 'locationName' => 'name',],
                'NoReboot' => ['shape' => 'Boolean', 'locationName' => 'noReboot',],
            ],
        ],
        'CreateImageResult' => [
            'type' => 'structure',
            'members' => ['ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],],
        ],
        'CreateInstanceExportTaskRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'ExportToS3Task' => ['shape' => 'ExportToS3TaskSpecification', 'locationName' => 'exportToS3',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'TargetEnvironment' => ['shape' => 'ExportEnvironment', 'locationName' => 'targetEnvironment',],
            ],
        ],
        'CreateInstanceExportTaskResult' => [
            'type' => 'structure',
            'members' => ['ExportTask' => ['shape' => 'ExportTask', 'locationName' => 'exportTask',],],
        ],
        'CreateInternetGatewayRequest' => [
            'type' => 'structure',
            'members' => ['DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],],
        ],
        'CreateInternetGatewayResult' => [
            'type' => 'structure',
            'members' => ['InternetGateway' => ['shape' => 'InternetGateway', 'locationName' => 'internetGateway',],],
        ],
        'CreateKeyPairRequest' => [
            'type' => 'structure',
            'required' => ['KeyName',],
            'members' => [
                'KeyName' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateNatGatewayRequest' => [
            'type' => 'structure',
            'required' => ['AllocationId', 'SubnetId',],
            'members' => [
                'AllocationId' => ['shape' => 'String',],
                'ClientToken' => ['shape' => 'String',],
                'SubnetId' => ['shape' => 'String',],
            ],
        ],
        'CreateNatGatewayResult' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'NatGateway' => ['shape' => 'NatGateway', 'locationName' => 'natGateway',],
            ],
        ],
        'CreateNetworkAclEntryRequest' => [
            'type' => 'structure',
            'required' => ['Egress', 'NetworkAclId', 'Protocol', 'RuleAction', 'RuleNumber',],
            'members' => [
                'CidrBlock' => ['shape' => 'String', 'locationName' => 'cidrBlock',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Egress' => ['shape' => 'Boolean', 'locationName' => 'egress',],
                'IcmpTypeCode' => ['shape' => 'IcmpTypeCode', 'locationName' => 'Icmp',],
                'Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
                'PortRange' => ['shape' => 'PortRange', 'locationName' => 'portRange',],
                'Protocol' => ['shape' => 'String', 'locationName' => 'protocol',],
                'RuleAction' => ['shape' => 'RuleAction', 'locationName' => 'ruleAction',],
                'RuleNumber' => ['shape' => 'Integer', 'locationName' => 'ruleNumber',],
            ],
        ],
        'CreateNetworkAclRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'CreateNetworkAclResult' => [
            'type' => 'structure',
            'members' => ['NetworkAcl' => ['shape' => 'NetworkAcl', 'locationName' => 'networkAcl',],],
        ],
        'CreateNetworkInterfaceRequest' => [
            'type' => 'structure',
            'required' => ['SubnetId',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Groups' => ['shape' => 'SecurityGroupIdStringList', 'locationName' => 'SecurityGroupId',],
                'Ipv6AddressCount' => ['shape' => 'Integer', 'locationName' => 'ipv6AddressCount',],
                'Ipv6Addresses' => ['shape' => 'InstanceIpv6AddressList', 'locationName' => 'ipv6Addresses',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'PrivateIpAddresses' => [
                    'shape' => 'PrivateIpAddressSpecificationList',
                    'locationName' => 'privateIpAddresses',
                ],
                'SecondaryPrivateIpAddressCount' => [
                    'shape' => 'Integer',
                    'locationName' => 'secondaryPrivateIpAddressCount',
                ],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'CreateNetworkInterfaceResult' => [
            'type' => 'structure',
            'members' => [
                'NetworkInterface' => [
                    'shape' => 'NetworkInterface',
                    'locationName' => 'networkInterface',
                ],
            ],
        ],
        'CreatePlacementGroupRequest' => [
            'type' => 'structure',
            'required' => ['GroupName', 'Strategy',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'Strategy' => ['shape' => 'PlacementStrategy', 'locationName' => 'strategy',],
            ],
        ],
        'CreateReservedInstancesListingRequest' => [
            'type' => 'structure',
            'required' => ['ClientToken', 'InstanceCount', 'PriceSchedules', 'ReservedInstancesId',],
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'PriceSchedules' => ['shape' => 'PriceScheduleSpecificationList', 'locationName' => 'priceSchedules',],
                'ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],
            ],
        ],
        'CreateReservedInstancesListingResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstancesListings' => [
                    'shape' => 'ReservedInstancesListingList',
                    'locationName' => 'reservedInstancesListingsSet',
                ],
            ],
        ],
        'CreateRouteRequest' => [
            'type' => 'structure',
            'required' => ['RouteTableId',],
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String', 'locationName' => 'destinationCidrBlock',],
                'DestinationIpv6CidrBlock' => ['shape' => 'String', 'locationName' => 'destinationIpv6CidrBlock',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EgressOnlyInternetGatewayId' => [
                    'shape' => 'String',
                    'locationName' => 'egressOnlyInternetGatewayId',
                ],
                'GatewayId' => ['shape' => 'String', 'locationName' => 'gatewayId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'NatGatewayId' => ['shape' => 'String', 'locationName' => 'natGatewayId',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'CreateRouteResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'CreateRouteTableRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'CreateRouteTableResult' => [
            'type' => 'structure',
            'members' => ['RouteTable' => ['shape' => 'RouteTable', 'locationName' => 'routeTable',],],
        ],
        'CreateSecurityGroupRequest' => [
            'type' => 'structure',
            'required' => ['Description', 'GroupName',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'GroupDescription',],
                'GroupName' => ['shape' => 'String',],
                'VpcId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateSecurityGroupResult' => [
            'type' => 'structure',
            'members' => ['GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],],
        ],
        'CreateSnapshotRequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'Description' => ['shape' => 'String',],
                'VolumeId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateSpotDatafeedSubscriptionRequest' => [
            'type' => 'structure',
            'required' => ['Bucket',],
            'members' => [
                'Bucket' => ['shape' => 'String', 'locationName' => 'bucket',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Prefix' => ['shape' => 'String', 'locationName' => 'prefix',],
            ],
        ],
        'CreateSpotDatafeedSubscriptionResult' => [
            'type' => 'structure',
            'members' => [
                'SpotDatafeedSubscription' => [
                    'shape' => 'SpotDatafeedSubscription',
                    'locationName' => 'spotDatafeedSubscription',
                ],
            ],
        ],
        'CreateSubnetRequest' => [
            'type' => 'structure',
            'required' => ['CidrBlock', 'VpcId',],
            'members' => [
                'AvailabilityZone' => ['shape' => 'String',],
                'CidrBlock' => ['shape' => 'String',],
                'Ipv6CidrBlock' => ['shape' => 'String',],
                'VpcId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateSubnetResult' => [
            'type' => 'structure',
            'members' => ['Subnet' => ['shape' => 'Subnet', 'locationName' => 'subnet',],],
        ],
        'CreateTagsRequest' => [
            'type' => 'structure',
            'required' => ['Resources', 'Tags',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Resources' => ['shape' => 'ResourceIdList', 'locationName' => 'ResourceId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'Tag',],
            ],
        ],
        'CreateVolumePermission' => [
            'type' => 'structure',
            'members' => [
                'Group' => ['shape' => 'PermissionGroup', 'locationName' => 'group',],
                'UserId' => ['shape' => 'String', 'locationName' => 'userId',],
            ],
        ],
        'CreateVolumePermissionList' => [
            'type' => 'list',
            'member' => ['shape' => 'CreateVolumePermission', 'locationName' => 'item',],
        ],
        'CreateVolumePermissionModifications' => [
            'type' => 'structure',
            'members' => [
                'Add' => ['shape' => 'CreateVolumePermissionList',],
                'Remove' => ['shape' => 'CreateVolumePermissionList',],
            ],
        ],
        'CreateVolumeRequest' => [
            'type' => 'structure',
            'required' => ['AvailabilityZone',],
            'members' => [
                'AvailabilityZone' => ['shape' => 'String',],
                'Encrypted' => ['shape' => 'Boolean', 'locationName' => 'encrypted',],
                'Iops' => ['shape' => 'Integer',],
                'KmsKeyId' => ['shape' => 'String',],
                'Size' => ['shape' => 'Integer',],
                'SnapshotId' => ['shape' => 'String',],
                'VolumeType' => ['shape' => 'VolumeType',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'TagSpecifications' => ['shape' => 'TagSpecificationList', 'locationName' => 'TagSpecification',],
            ],
        ],
        'CreateVpcEndpointRequest' => [
            'type' => 'structure',
            'required' => ['ServiceName', 'VpcId',],
            'members' => [
                'ClientToken' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean',],
                'PolicyDocument' => ['shape' => 'String',],
                'RouteTableIds' => ['shape' => 'ValueStringList', 'locationName' => 'RouteTableId',],
                'ServiceName' => ['shape' => 'String',],
                'VpcId' => ['shape' => 'String',],
            ],
        ],
        'CreateVpcEndpointResult' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'VpcEndpoint' => ['shape' => 'VpcEndpoint', 'locationName' => 'vpcEndpoint',],
            ],
        ],
        'CreateVpcPeeringConnectionRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'PeerOwnerId' => ['shape' => 'String', 'locationName' => 'peerOwnerId',],
                'PeerVpcId' => ['shape' => 'String', 'locationName' => 'peerVpcId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'CreateVpcPeeringConnectionResult' => [
            'type' => 'structure',
            'members' => [
                'VpcPeeringConnection' => [
                    'shape' => 'VpcPeeringConnection',
                    'locationName' => 'vpcPeeringConnection',
                ],
            ],
        ],
        'CreateVpcRequest' => [
            'type' => 'structure',
            'required' => ['CidrBlock',],
            'members' => [
                'CidrBlock' => ['shape' => 'String',],
                'AmazonProvidedIpv6CidrBlock' => [
                    'shape' => 'Boolean',
                    'locationName' => 'amazonProvidedIpv6CidrBlock',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceTenancy' => ['shape' => 'Tenancy', 'locationName' => 'instanceTenancy',],
            ],
        ],
        'CreateVpcResult' => [
            'type' => 'structure',
            'members' => ['Vpc' => ['shape' => 'Vpc', 'locationName' => 'vpc',],],
        ],
        'CreateVpnConnectionRequest' => [
            'type' => 'structure',
            'required' => ['CustomerGatewayId', 'Type', 'VpnGatewayId',],
            'members' => [
                'CustomerGatewayId' => ['shape' => 'String',],
                'Type' => ['shape' => 'String',],
                'VpnGatewayId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Options' => ['shape' => 'VpnConnectionOptionsSpecification', 'locationName' => 'options',],
            ],
        ],
        'CreateVpnConnectionResult' => [
            'type' => 'structure',
            'members' => ['VpnConnection' => ['shape' => 'VpnConnection', 'locationName' => 'vpnConnection',],],
        ],
        'CreateVpnConnectionRouteRequest' => [
            'type' => 'structure',
            'required' => ['DestinationCidrBlock', 'VpnConnectionId',],
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String',],
                'VpnConnectionId' => ['shape' => 'String',],
            ],
        ],
        'CreateVpnGatewayRequest' => [
            'type' => 'structure',
            'required' => ['Type',],
            'members' => [
                'AvailabilityZone' => ['shape' => 'String',],
                'Type' => ['shape' => 'GatewayType',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'CreateVpnGatewayResult' => [
            'type' => 'structure',
            'members' => ['VpnGateway' => ['shape' => 'VpnGateway', 'locationName' => 'vpnGateway',],],
        ],
        'CurrencyCodeValues' => ['type' => 'string', 'enum' => ['USD',],],
        'CustomerGateway' => [
            'type' => 'structure',
            'members' => [
                'BgpAsn' => ['shape' => 'String', 'locationName' => 'bgpAsn',],
                'CustomerGatewayId' => ['shape' => 'String', 'locationName' => 'customerGatewayId',],
                'IpAddress' => ['shape' => 'String', 'locationName' => 'ipAddress',],
                'State' => ['shape' => 'String', 'locationName' => 'state',],
                'Type' => ['shape' => 'String', 'locationName' => 'type',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'CustomerGatewayIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'CustomerGatewayId',],
        ],
        'CustomerGatewayList' => [
            'type' => 'list',
            'member' => ['shape' => 'CustomerGateway', 'locationName' => 'item',],
        ],
        'DatafeedSubscriptionState' => ['type' => 'string', 'enum' => ['Active', 'Inactive',],],
        'DateTime' => ['type' => 'timestamp',],
        'DeleteCustomerGatewayRequest' => [
            'type' => 'structure',
            'required' => ['CustomerGatewayId',],
            'members' => [
                'CustomerGatewayId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteDhcpOptionsRequest' => [
            'type' => 'structure',
            'required' => ['DhcpOptionsId',],
            'members' => [
                'DhcpOptionsId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteEgressOnlyInternetGatewayRequest' => [
            'type' => 'structure',
            'required' => ['EgressOnlyInternetGatewayId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'EgressOnlyInternetGatewayId' => ['shape' => 'EgressOnlyInternetGatewayId',],
            ],
        ],
        'DeleteEgressOnlyInternetGatewayResult' => [
            'type' => 'structure',
            'members' => ['ReturnCode' => ['shape' => 'Boolean', 'locationName' => 'returnCode',],],
        ],
        'DeleteFlowLogsRequest' => [
            'type' => 'structure',
            'required' => ['FlowLogIds',],
            'members' => ['FlowLogIds' => ['shape' => 'ValueStringList', 'locationName' => 'FlowLogId',],],
        ],
        'DeleteFlowLogsResult' => [
            'type' => 'structure',
            'members' => ['Unsuccessful' => ['shape' => 'UnsuccessfulItemSet', 'locationName' => 'unsuccessful',],],
        ],
        'DeleteInternetGatewayRequest' => [
            'type' => 'structure',
            'required' => ['InternetGatewayId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InternetGatewayId' => ['shape' => 'String', 'locationName' => 'internetGatewayId',],
            ],
        ],
        'DeleteKeyPairRequest' => [
            'type' => 'structure',
            'required' => ['KeyName',],
            'members' => [
                'KeyName' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteNatGatewayRequest' => [
            'type' => 'structure',
            'required' => ['NatGatewayId',],
            'members' => ['NatGatewayId' => ['shape' => 'String',],],
        ],
        'DeleteNatGatewayResult' => [
            'type' => 'structure',
            'members' => ['NatGatewayId' => ['shape' => 'String', 'locationName' => 'natGatewayId',],],
        ],
        'DeleteNetworkAclEntryRequest' => [
            'type' => 'structure',
            'required' => ['Egress', 'NetworkAclId', 'RuleNumber',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Egress' => ['shape' => 'Boolean', 'locationName' => 'egress',],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
                'RuleNumber' => ['shape' => 'Integer', 'locationName' => 'ruleNumber',],
            ],
        ],
        'DeleteNetworkAclRequest' => [
            'type' => 'structure',
            'required' => ['NetworkAclId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
            ],
        ],
        'DeleteNetworkInterfaceRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
            ],
        ],
        'DeletePlacementGroupRequest' => [
            'type' => 'structure',
            'required' => ['GroupName',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
            ],
        ],
        'DeleteRouteRequest' => [
            'type' => 'structure',
            'required' => ['RouteTableId',],
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String', 'locationName' => 'destinationCidrBlock',],
                'DestinationIpv6CidrBlock' => ['shape' => 'String', 'locationName' => 'destinationIpv6CidrBlock',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
            ],
        ],
        'DeleteRouteTableRequest' => [
            'type' => 'structure',
            'required' => ['RouteTableId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
            ],
        ],
        'DeleteSecurityGroupRequest' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => 'String',],
                'GroupName' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteSnapshotRequest' => [
            'type' => 'structure',
            'required' => ['SnapshotId',],
            'members' => [
                'SnapshotId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteSpotDatafeedSubscriptionRequest' => [
            'type' => 'structure',
            'members' => ['DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],],
        ],
        'DeleteSubnetRequest' => [
            'type' => 'structure',
            'required' => ['SubnetId',],
            'members' => [
                'SubnetId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteTagsRequest' => [
            'type' => 'structure',
            'required' => ['Resources',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Resources' => ['shape' => 'ResourceIdList', 'locationName' => 'resourceId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tag',],
            ],
        ],
        'DeleteVolumeRequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'VolumeId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteVpcEndpointsRequest' => [
            'type' => 'structure',
            'required' => ['VpcEndpointIds',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'VpcEndpointIds' => ['shape' => 'ValueStringList', 'locationName' => 'VpcEndpointId',],
            ],
        ],
        'DeleteVpcEndpointsResult' => [
            'type' => 'structure',
            'members' => ['Unsuccessful' => ['shape' => 'UnsuccessfulItemSet', 'locationName' => 'unsuccessful',],],
        ],
        'DeleteVpcPeeringConnectionRequest' => [
            'type' => 'structure',
            'required' => ['VpcPeeringConnectionId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'DeleteVpcPeeringConnectionResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'DeleteVpcRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'VpcId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteVpnConnectionRequest' => [
            'type' => 'structure',
            'required' => ['VpnConnectionId',],
            'members' => [
                'VpnConnectionId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeleteVpnConnectionRouteRequest' => [
            'type' => 'structure',
            'required' => ['DestinationCidrBlock', 'VpnConnectionId',],
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String',],
                'VpnConnectionId' => ['shape' => 'String',],
            ],
        ],
        'DeleteVpnGatewayRequest' => [
            'type' => 'structure',
            'required' => ['VpnGatewayId',],
            'members' => [
                'VpnGatewayId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeregisterImageRequest' => [
            'type' => 'structure',
            'required' => ['ImageId',],
            'members' => [
                'ImageId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeAccountAttributesRequest' => [
            'type' => 'structure',
            'members' => [
                'AttributeNames' => [
                    'shape' => 'AccountAttributeNameStringList',
                    'locationName' => 'attributeName',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeAccountAttributesResult' => [
            'type' => 'structure',
            'members' => [
                'AccountAttributes' => [
                    'shape' => 'AccountAttributeList',
                    'locationName' => 'accountAttributeSet',
                ],
            ],
        ],
        'DescribeAddressesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'PublicIps' => ['shape' => 'PublicIpStringList', 'locationName' => 'PublicIp',],
                'AllocationIds' => ['shape' => 'AllocationIdList', 'locationName' => 'AllocationId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeAddressesResult' => [
            'type' => 'structure',
            'members' => ['Addresses' => ['shape' => 'AddressList', 'locationName' => 'addressesSet',],],
        ],
        'DescribeAvailabilityZonesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'ZoneNames' => ['shape' => 'ZoneNameStringList', 'locationName' => 'ZoneName',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeAvailabilityZonesResult' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZones' => [
                    'shape' => 'AvailabilityZoneList',
                    'locationName' => 'availabilityZoneInfo',
                ],
            ],
        ],
        'DescribeBundleTasksRequest' => [
            'type' => 'structure',
            'members' => [
                'BundleIds' => ['shape' => 'BundleIdStringList', 'locationName' => 'BundleId',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeBundleTasksResult' => [
            'type' => 'structure',
            'members' => ['BundleTasks' => ['shape' => 'BundleTaskList', 'locationName' => 'bundleInstanceTasksSet',],],
        ],
        'DescribeClassicLinkInstancesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeClassicLinkInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'Instances' => ['shape' => 'ClassicLinkInstanceList', 'locationName' => 'instancesSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeConversionTaskList' => [
            'type' => 'list',
            'member' => ['shape' => 'ConversionTask', 'locationName' => 'item',],
        ],
        'DescribeConversionTasksRequest' => [
            'type' => 'structure',
            'members' => [
                'ConversionTaskIds' => [
                    'shape' => 'ConversionIdStringList',
                    'locationName' => 'conversionTaskId',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeConversionTasksResult' => [
            'type' => 'structure',
            'members' => [
                'ConversionTasks' => [
                    'shape' => 'DescribeConversionTaskList',
                    'locationName' => 'conversionTasks',
                ],
            ],
        ],
        'DescribeCustomerGatewaysRequest' => [
            'type' => 'structure',
            'members' => [
                'CustomerGatewayIds' => [
                    'shape' => 'CustomerGatewayIdStringList',
                    'locationName' => 'CustomerGatewayId',
                ],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeCustomerGatewaysResult' => [
            'type' => 'structure',
            'members' => [
                'CustomerGateways' => [
                    'shape' => 'CustomerGatewayList',
                    'locationName' => 'customerGatewaySet',
                ],
            ],
        ],
        'DescribeDhcpOptionsRequest' => [
            'type' => 'structure',
            'members' => [
                'DhcpOptionsIds' => [
                    'shape' => 'DhcpOptionsIdStringList',
                    'locationName' => 'DhcpOptionsId',
                ],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeDhcpOptionsResult' => [
            'type' => 'structure',
            'members' => ['DhcpOptions' => ['shape' => 'DhcpOptionsList', 'locationName' => 'dhcpOptionsSet',],],
        ],
        'DescribeEgressOnlyInternetGatewaysRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'EgressOnlyInternetGatewayIds' => [
                    'shape' => 'EgressOnlyInternetGatewayIdList',
                    'locationName' => 'EgressOnlyInternetGatewayId',
                ],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeEgressOnlyInternetGatewaysResult' => [
            'type' => 'structure',
            'members' => [
                'EgressOnlyInternetGateways' => [
                    'shape' => 'EgressOnlyInternetGatewayList',
                    'locationName' => 'egressOnlyInternetGatewaySet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeExportTasksRequest' => [
            'type' => 'structure',
            'members' => ['ExportTaskIds' => ['shape' => 'ExportTaskIdStringList', 'locationName' => 'exportTaskId',],],
        ],
        'DescribeExportTasksResult' => [
            'type' => 'structure',
            'members' => ['ExportTasks' => ['shape' => 'ExportTaskList', 'locationName' => 'exportTaskSet',],],
        ],
        'DescribeFlowLogsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filter' => ['shape' => 'FilterList',],
                'FlowLogIds' => ['shape' => 'ValueStringList', 'locationName' => 'FlowLogId',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeFlowLogsResult' => [
            'type' => 'structure',
            'members' => [
                'FlowLogs' => ['shape' => 'FlowLogSet', 'locationName' => 'flowLogSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeFpgaImagesRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'FpgaImageIds' => ['shape' => 'FpgaImageIdList', 'locationName' => 'FpgaImageId',],
                'Owners' => ['shape' => 'OwnerStringList', 'locationName' => 'Owner',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'NextToken' => ['shape' => 'NextToken',],
                'MaxResults' => ['shape' => 'MaxResults',],
            ],
        ],
        'DescribeFpgaImagesResult' => [
            'type' => 'structure',
            'members' => [
                'FpgaImages' => ['shape' => 'FpgaImageList', 'locationName' => 'fpgaImageSet',],
                'NextToken' => ['shape' => 'NextToken', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeHostReservationOfferingsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filter' => ['shape' => 'FilterList',],
                'MaxDuration' => ['shape' => 'Integer',],
                'MaxResults' => ['shape' => 'Integer',],
                'MinDuration' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'OfferingId' => ['shape' => 'String',],
            ],
        ],
        'DescribeHostReservationOfferingsResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'OfferingSet' => ['shape' => 'HostOfferingSet', 'locationName' => 'offeringSet',],
            ],
        ],
        'DescribeHostReservationsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filter' => ['shape' => 'FilterList',],
                'HostReservationIdSet' => ['shape' => 'HostReservationIdSet',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeHostReservationsResult' => [
            'type' => 'structure',
            'members' => [
                'HostReservationSet' => [
                    'shape' => 'HostReservationSet',
                    'locationName' => 'hostReservationSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeHostsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filter' => ['shape' => 'FilterList', 'locationName' => 'filter',],
                'HostIds' => ['shape' => 'RequestHostIdList', 'locationName' => 'hostId',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeHostsResult' => [
            'type' => 'structure',
            'members' => [
                'Hosts' => ['shape' => 'HostList', 'locationName' => 'hostSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeIamInstanceProfileAssociationsRequest' => [
            'type' => 'structure',
            'members' => [
                'AssociationIds' => ['shape' => 'AssociationIdList', 'locationName' => 'AssociationId',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'MaxResults',],
                'NextToken' => ['shape' => 'NextToken',],
            ],
        ],
        'DescribeIamInstanceProfileAssociationsResult' => [
            'type' => 'structure',
            'members' => [
                'IamInstanceProfileAssociations' => [
                    'shape' => 'IamInstanceProfileAssociationSet',
                    'locationName' => 'iamInstanceProfileAssociationSet',
                ],
                'NextToken' => ['shape' => 'NextToken', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeIdFormatRequest' => ['type' => 'structure', 'members' => ['Resource' => ['shape' => 'String',],],],
        'DescribeIdFormatResult' => [
            'type' => 'structure',
            'members' => ['Statuses' => ['shape' => 'IdFormatList', 'locationName' => 'statusSet',],],
        ],
        'DescribeIdentityIdFormatRequest' => [
            'type' => 'structure',
            'required' => ['PrincipalArn',],
            'members' => [
                'PrincipalArn' => ['shape' => 'String', 'locationName' => 'principalArn',],
                'Resource' => ['shape' => 'String', 'locationName' => 'resource',],
            ],
        ],
        'DescribeIdentityIdFormatResult' => [
            'type' => 'structure',
            'members' => ['Statuses' => ['shape' => 'IdFormatList', 'locationName' => 'statusSet',],],
        ],
        'DescribeImageAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'ImageId',],
            'members' => [
                'Attribute' => ['shape' => 'ImageAttributeName',],
                'ImageId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeImagesRequest' => [
            'type' => 'structure',
            'members' => [
                'ExecutableUsers' => ['shape' => 'ExecutableByStringList', 'locationName' => 'ExecutableBy',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'ImageIds' => ['shape' => 'ImageIdStringList', 'locationName' => 'ImageId',],
                'Owners' => ['shape' => 'OwnerStringList', 'locationName' => 'Owner',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeImagesResult' => [
            'type' => 'structure',
            'members' => ['Images' => ['shape' => 'ImageList', 'locationName' => 'imagesSet',],],
        ],
        'DescribeImportImageTasksRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'Filters' => ['shape' => 'FilterList',],
                'ImportTaskIds' => ['shape' => 'ImportTaskIdList', 'locationName' => 'ImportTaskId',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeImportImageTasksResult' => [
            'type' => 'structure',
            'members' => [
                'ImportImageTasks' => [
                    'shape' => 'ImportImageTaskList',
                    'locationName' => 'importImageTaskSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeImportSnapshotTasksRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'Filters' => ['shape' => 'FilterList',],
                'ImportTaskIds' => ['shape' => 'ImportTaskIdList', 'locationName' => 'ImportTaskId',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeImportSnapshotTasksResult' => [
            'type' => 'structure',
            'members' => [
                'ImportSnapshotTasks' => [
                    'shape' => 'ImportSnapshotTaskList',
                    'locationName' => 'importSnapshotTaskSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeInstanceAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'InstanceId',],
            'members' => [
                'Attribute' => ['shape' => 'InstanceAttributeName', 'locationName' => 'attribute',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
            ],
        ],
        'DescribeInstanceStatusRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'IncludeAllInstances' => ['shape' => 'Boolean', 'locationName' => 'includeAllInstances',],
            ],
        ],
        'DescribeInstanceStatusResult' => [
            'type' => 'structure',
            'members' => [
                'InstanceStatuses' => [
                    'shape' => 'InstanceStatusList',
                    'locationName' => 'instanceStatusSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeInstancesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'Reservations' => ['shape' => 'ReservationList', 'locationName' => 'reservationSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeInternetGatewaysRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InternetGatewayIds' => ['shape' => 'ValueStringList', 'locationName' => 'internetGatewayId',],
            ],
        ],
        'DescribeInternetGatewaysResult' => [
            'type' => 'structure',
            'members' => [
                'InternetGateways' => [
                    'shape' => 'InternetGatewayList',
                    'locationName' => 'internetGatewaySet',
                ],
            ],
        ],
        'DescribeKeyPairsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'KeyNames' => ['shape' => 'KeyNameStringList', 'locationName' => 'KeyName',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeKeyPairsResult' => [
            'type' => 'structure',
            'members' => ['KeyPairs' => ['shape' => 'KeyPairList', 'locationName' => 'keySet',],],
        ],
        'DescribeMovingAddressesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'PublicIps' => ['shape' => 'ValueStringList', 'locationName' => 'publicIp',],
            ],
        ],
        'DescribeMovingAddressesResult' => [
            'type' => 'structure',
            'members' => [
                'MovingAddressStatuses' => [
                    'shape' => 'MovingAddressStatusSet',
                    'locationName' => 'movingAddressStatusSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeNatGatewaysRequest' => [
            'type' => 'structure',
            'members' => [
                'Filter' => ['shape' => 'FilterList',],
                'MaxResults' => ['shape' => 'Integer',],
                'NatGatewayIds' => ['shape' => 'ValueStringList', 'locationName' => 'NatGatewayId',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeNatGatewaysResult' => [
            'type' => 'structure',
            'members' => [
                'NatGateways' => ['shape' => 'NatGatewayList', 'locationName' => 'natGatewaySet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeNetworkAclsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkAclIds' => ['shape' => 'ValueStringList', 'locationName' => 'NetworkAclId',],
            ],
        ],
        'DescribeNetworkAclsResult' => [
            'type' => 'structure',
            'members' => ['NetworkAcls' => ['shape' => 'NetworkAclList', 'locationName' => 'networkAclSet',],],
        ],
        'DescribeNetworkInterfaceAttributeRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId',],
            'members' => [
                'Attribute' => ['shape' => 'NetworkInterfaceAttribute', 'locationName' => 'attribute',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
            ],
        ],
        'DescribeNetworkInterfaceAttributeResult' => [
            'type' => 'structure',
            'members' => [
                'Attachment' => ['shape' => 'NetworkInterfaceAttachment', 'locationName' => 'attachment',],
                'Description' => ['shape' => 'AttributeValue', 'locationName' => 'description',],
                'Groups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'SourceDestCheck' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'sourceDestCheck',],
            ],
        ],
        'DescribeNetworkInterfacesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkInterfaceIds' => ['shape' => 'NetworkInterfaceIdList', 'locationName' => 'NetworkInterfaceId',],
            ],
        ],
        'DescribeNetworkInterfacesResult' => [
            'type' => 'structure',
            'members' => [
                'NetworkInterfaces' => [
                    'shape' => 'NetworkInterfaceList',
                    'locationName' => 'networkInterfaceSet',
                ],
            ],
        ],
        'DescribePlacementGroupsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'GroupNames' => ['shape' => 'PlacementGroupStringList', 'locationName' => 'groupName',],
            ],
        ],
        'DescribePlacementGroupsResult' => [
            'type' => 'structure',
            'members' => [
                'PlacementGroups' => [
                    'shape' => 'PlacementGroupList',
                    'locationName' => 'placementGroupSet',
                ],
            ],
        ],
        'DescribePrefixListsRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'PrefixListIds' => ['shape' => 'ValueStringList', 'locationName' => 'PrefixListId',],
            ],
        ],
        'DescribePrefixListsResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'PrefixLists' => ['shape' => 'PrefixListSet', 'locationName' => 'prefixListSet',],
            ],
        ],
        'DescribeRegionsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'RegionNames' => ['shape' => 'RegionNameStringList', 'locationName' => 'RegionName',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeRegionsResult' => [
            'type' => 'structure',
            'members' => ['Regions' => ['shape' => 'RegionList', 'locationName' => 'regionInfo',],],
        ],
        'DescribeReservedInstancesListingsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],
                'ReservedInstancesListingId' => ['shape' => 'String', 'locationName' => 'reservedInstancesListingId',],
            ],
        ],
        'DescribeReservedInstancesListingsResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstancesListings' => [
                    'shape' => 'ReservedInstancesListingList',
                    'locationName' => 'reservedInstancesListingsSet',
                ],
            ],
        ],
        'DescribeReservedInstancesModificationsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'ReservedInstancesModificationIds' => [
                    'shape' => 'ReservedInstancesModificationIdStringList',
                    'locationName' => 'ReservedInstancesModificationId',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeReservedInstancesModificationsResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'ReservedInstancesModifications' => [
                    'shape' => 'ReservedInstancesModificationList',
                    'locationName' => 'reservedInstancesModificationsSet',
                ],
            ],
        ],
        'DescribeReservedInstancesOfferingsRequest' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'IncludeMarketplace' => ['shape' => 'Boolean',],
                'InstanceType' => ['shape' => 'InstanceType',],
                'MaxDuration' => ['shape' => 'Long',],
                'MaxInstanceCount' => ['shape' => 'Integer',],
                'MinDuration' => ['shape' => 'Long',],
                'OfferingClass' => ['shape' => 'OfferingClassType',],
                'ProductDescription' => ['shape' => 'RIProductDescription',],
                'ReservedInstancesOfferingIds' => [
                    'shape' => 'ReservedInstancesOfferingIdStringList',
                    'locationName' => 'ReservedInstancesOfferingId',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceTenancy' => ['shape' => 'Tenancy', 'locationName' => 'instanceTenancy',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'OfferingType' => ['shape' => 'OfferingTypeValues', 'locationName' => 'offeringType',],
            ],
        ],
        'DescribeReservedInstancesOfferingsResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstancesOfferings' => [
                    'shape' => 'ReservedInstancesOfferingList',
                    'locationName' => 'reservedInstancesOfferingsSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeReservedInstancesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'OfferingClass' => ['shape' => 'OfferingClassType',],
                'ReservedInstancesIds' => [
                    'shape' => 'ReservedInstancesIdStringList',
                    'locationName' => 'ReservedInstancesId',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'OfferingType' => ['shape' => 'OfferingTypeValues', 'locationName' => 'offeringType',],
            ],
        ],
        'DescribeReservedInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstances' => [
                    'shape' => 'ReservedInstancesList',
                    'locationName' => 'reservedInstancesSet',
                ],
            ],
        ],
        'DescribeRouteTablesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'RouteTableIds' => ['shape' => 'ValueStringList', 'locationName' => 'RouteTableId',],
            ],
        ],
        'DescribeRouteTablesResult' => [
            'type' => 'structure',
            'members' => ['RouteTables' => ['shape' => 'RouteTableList', 'locationName' => 'routeTableSet',],],
        ],
        'DescribeScheduledInstanceAvailabilityRequest' => [
            'type' => 'structure',
            'required' => ['FirstSlotStartTimeRange', 'Recurrence',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'FirstSlotStartTimeRange' => ['shape' => 'SlotDateTimeRangeRequest',],
                'MaxResults' => ['shape' => 'Integer',],
                'MaxSlotDurationInHours' => ['shape' => 'Integer',],
                'MinSlotDurationInHours' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'Recurrence' => ['shape' => 'ScheduledInstanceRecurrenceRequest',],
            ],
        ],
        'DescribeScheduledInstanceAvailabilityResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'ScheduledInstanceAvailabilitySet' => [
                    'shape' => 'ScheduledInstanceAvailabilitySet',
                    'locationName' => 'scheduledInstanceAvailabilitySet',
                ],
            ],
        ],
        'DescribeScheduledInstancesRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'ScheduledInstanceIds' => [
                    'shape' => 'ScheduledInstanceIdRequestSet',
                    'locationName' => 'ScheduledInstanceId',
                ],
                'SlotStartTimeRange' => ['shape' => 'SlotStartTimeRangeRequest',],
            ],
        ],
        'DescribeScheduledInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'ScheduledInstanceSet' => [
                    'shape' => 'ScheduledInstanceSet',
                    'locationName' => 'scheduledInstanceSet',
                ],
            ],
        ],
        'DescribeSecurityGroupReferencesRequest' => [
            'type' => 'structure',
            'required' => ['GroupId',],
            'members' => ['DryRun' => ['shape' => 'Boolean',], 'GroupId' => ['shape' => 'GroupIds',],],
        ],
        'DescribeSecurityGroupReferencesResult' => [
            'type' => 'structure',
            'members' => [
                'SecurityGroupReferenceSet' => [
                    'shape' => 'SecurityGroupReferences',
                    'locationName' => 'securityGroupReferenceSet',
                ],
            ],
        ],
        'DescribeSecurityGroupsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'GroupIds' => ['shape' => 'GroupIdStringList', 'locationName' => 'GroupId',],
                'GroupNames' => ['shape' => 'GroupNameStringList', 'locationName' => 'GroupName',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeSecurityGroupsResult' => [
            'type' => 'structure',
            'members' => [
                'SecurityGroups' => [
                    'shape' => 'SecurityGroupList',
                    'locationName' => 'securityGroupInfo',
                ],
            ],
        ],
        'DescribeSnapshotAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'SnapshotId',],
            'members' => [
                'Attribute' => ['shape' => 'SnapshotAttributeName',],
                'SnapshotId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeSnapshotAttributeResult' => [
            'type' => 'structure',
            'members' => [
                'CreateVolumePermissions' => [
                    'shape' => 'CreateVolumePermissionList',
                    'locationName' => 'createVolumePermission',
                ],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],
            ],
        ],
        'DescribeSnapshotsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'OwnerIds' => ['shape' => 'OwnerStringList', 'locationName' => 'Owner',],
                'RestorableByUserIds' => ['shape' => 'RestorableByStringList', 'locationName' => 'RestorableBy',],
                'SnapshotIds' => ['shape' => 'SnapshotIdStringList', 'locationName' => 'SnapshotId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeSnapshotsResult' => [
            'type' => 'structure',
            'members' => [
                'Snapshots' => ['shape' => 'SnapshotList', 'locationName' => 'snapshotSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeSpotDatafeedSubscriptionRequest' => [
            'type' => 'structure',
            'members' => ['DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],],
        ],
        'DescribeSpotDatafeedSubscriptionResult' => [
            'type' => 'structure',
            'members' => [
                'SpotDatafeedSubscription' => [
                    'shape' => 'SpotDatafeedSubscription',
                    'locationName' => 'spotDatafeedSubscription',
                ],
            ],
        ],
        'DescribeSpotFleetInstancesRequest' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
            ],
        ],
        'DescribeSpotFleetInstancesResponse' => [
            'type' => 'structure',
            'required' => ['ActiveInstances', 'SpotFleetRequestId',],
            'members' => [
                'ActiveInstances' => ['shape' => 'ActiveInstanceSet', 'locationName' => 'activeInstanceSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
            ],
        ],
        'DescribeSpotFleetRequestHistoryRequest' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestId', 'StartTime',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EventType' => ['shape' => 'EventType', 'locationName' => 'eventType',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
            ],
        ],
        'DescribeSpotFleetRequestHistoryResponse' => [
            'type' => 'structure',
            'required' => ['HistoryRecords', 'LastEvaluatedTime', 'SpotFleetRequestId', 'StartTime',],
            'members' => [
                'HistoryRecords' => ['shape' => 'HistoryRecords', 'locationName' => 'historyRecordSet',],
                'LastEvaluatedTime' => ['shape' => 'DateTime', 'locationName' => 'lastEvaluatedTime',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
            ],
        ],
        'DescribeSpotFleetRequestsRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotFleetRequestIds' => ['shape' => 'ValueStringList', 'locationName' => 'spotFleetRequestId',],
            ],
        ],
        'DescribeSpotFleetRequestsResponse' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestConfigs',],
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotFleetRequestConfigs' => [
                    'shape' => 'SpotFleetRequestConfigSet',
                    'locationName' => 'spotFleetRequestConfigSet',
                ],
            ],
        ],
        'DescribeSpotInstanceRequestsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'SpotInstanceRequestIds' => [
                    'shape' => 'SpotInstanceRequestIdList',
                    'locationName' => 'SpotInstanceRequestId',
                ],
            ],
        ],
        'DescribeSpotInstanceRequestsResult' => [
            'type' => 'structure',
            'members' => [
                'SpotInstanceRequests' => [
                    'shape' => 'SpotInstanceRequestList',
                    'locationName' => 'spotInstanceRequestSet',
                ],
            ],
        ],
        'DescribeSpotPriceHistoryRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EndTime' => ['shape' => 'DateTime', 'locationName' => 'endTime',],
                'InstanceTypes' => ['shape' => 'InstanceTypeList', 'locationName' => 'InstanceType',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'ProductDescriptions' => ['shape' => 'ProductDescriptionList', 'locationName' => 'ProductDescription',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
            ],
        ],
        'DescribeSpotPriceHistoryResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'SpotPriceHistory' => ['shape' => 'SpotPriceHistoryList', 'locationName' => 'spotPriceHistorySet',],
            ],
        ],
        'DescribeStaleSecurityGroupsRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'MaxResults' => ['shape' => 'MaxResults',],
                'NextToken' => ['shape' => 'NextToken',],
                'VpcId' => ['shape' => 'String',],
            ],
        ],
        'DescribeStaleSecurityGroupsResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'StaleSecurityGroupSet' => [
                    'shape' => 'StaleSecurityGroupSet',
                    'locationName' => 'staleSecurityGroupSet',
                ],
            ],
        ],
        'DescribeSubnetsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'SubnetIds' => ['shape' => 'SubnetIdStringList', 'locationName' => 'SubnetId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeSubnetsResult' => [
            'type' => 'structure',
            'members' => ['Subnets' => ['shape' => 'SubnetList', 'locationName' => 'subnetSet',],],
        ],
        'DescribeTagsRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeTagsResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'Tags' => ['shape' => 'TagDescriptionList', 'locationName' => 'tagSet',],
            ],
        ],
        'DescribeVolumeAttributeRequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'Attribute' => ['shape' => 'VolumeAttributeName',],
                'VolumeId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeVolumeAttributeResult' => [
            'type' => 'structure',
            'members' => [
                'AutoEnableIO' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'autoEnableIO',],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
            ],
        ],
        'DescribeVolumeStatusRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'VolumeIds' => ['shape' => 'VolumeIdStringList', 'locationName' => 'VolumeId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeVolumeStatusResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'VolumeStatuses' => ['shape' => 'VolumeStatusList', 'locationName' => 'volumeStatusSet',],
            ],
        ],
        'DescribeVolumesModificationsRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'VolumeIds' => ['shape' => 'VolumeIdStringList', 'locationName' => 'VolumeId',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'NextToken' => ['shape' => 'String',],
                'MaxResults' => ['shape' => 'Integer',],
            ],
        ],
        'DescribeVolumesModificationsResult' => [
            'type' => 'structure',
            'members' => [
                'VolumesModifications' => [
                    'shape' => 'VolumeModificationList',
                    'locationName' => 'volumeModificationSet',
                ],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeVolumesRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'VolumeIds' => ['shape' => 'VolumeIdStringList', 'locationName' => 'VolumeId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'MaxResults' => ['shape' => 'Integer', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeVolumesResult' => [
            'type' => 'structure',
            'members' => [
                'Volumes' => ['shape' => 'VolumeList', 'locationName' => 'volumeSet',],
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
            ],
        ],
        'DescribeVpcAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'VpcId',],
            'members' => [
                'Attribute' => ['shape' => 'VpcAttributeName',],
                'VpcId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeVpcAttributeResult' => [
            'type' => 'structure',
            'members' => [
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
                'EnableDnsHostnames' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'enableDnsHostnames',],
                'EnableDnsSupport' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'enableDnsSupport',],
            ],
        ],
        'DescribeVpcClassicLinkDnsSupportRequest' => [
            'type' => 'structure',
            'members' => [
                'MaxResults' => ['shape' => 'MaxResults', 'locationName' => 'maxResults',],
                'NextToken' => ['shape' => 'NextToken', 'locationName' => 'nextToken',],
                'VpcIds' => ['shape' => 'VpcClassicLinkIdList',],
            ],
        ],
        'DescribeVpcClassicLinkDnsSupportResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'NextToken', 'locationName' => 'nextToken',],
                'Vpcs' => ['shape' => 'ClassicLinkDnsSupportList', 'locationName' => 'vpcs',],
            ],
        ],
        'DescribeVpcClassicLinkRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcIds' => ['shape' => 'VpcClassicLinkIdList', 'locationName' => 'VpcId',],
            ],
        ],
        'DescribeVpcClassicLinkResult' => [
            'type' => 'structure',
            'members' => ['Vpcs' => ['shape' => 'VpcClassicLinkList', 'locationName' => 'vpcSet',],],
        ],
        'DescribeVpcEndpointServicesRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
            ],
        ],
        'DescribeVpcEndpointServicesResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'ServiceNames' => ['shape' => 'ValueStringList', 'locationName' => 'serviceNameSet',],
            ],
        ],
        'DescribeVpcEndpointsRequest' => [
            'type' => 'structure',
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'MaxResults' => ['shape' => 'Integer',],
                'NextToken' => ['shape' => 'String',],
                'VpcEndpointIds' => ['shape' => 'ValueStringList', 'locationName' => 'VpcEndpointId',],
            ],
        ],
        'DescribeVpcEndpointsResult' => [
            'type' => 'structure',
            'members' => [
                'NextToken' => ['shape' => 'String', 'locationName' => 'nextToken',],
                'VpcEndpoints' => ['shape' => 'VpcEndpointSet', 'locationName' => 'vpcEndpointSet',],
            ],
        ],
        'DescribeVpcPeeringConnectionsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcPeeringConnectionIds' => [
                    'shape' => 'ValueStringList',
                    'locationName' => 'VpcPeeringConnectionId',
                ],
            ],
        ],
        'DescribeVpcPeeringConnectionsResult' => [
            'type' => 'structure',
            'members' => [
                'VpcPeeringConnections' => [
                    'shape' => 'VpcPeeringConnectionList',
                    'locationName' => 'vpcPeeringConnectionSet',
                ],
            ],
        ],
        'DescribeVpcsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'VpcIds' => ['shape' => 'VpcIdStringList', 'locationName' => 'VpcId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeVpcsResult' => [
            'type' => 'structure',
            'members' => ['Vpcs' => ['shape' => 'VpcList', 'locationName' => 'vpcSet',],],
        ],
        'DescribeVpnConnectionsRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'VpnConnectionIds' => ['shape' => 'VpnConnectionIdStringList', 'locationName' => 'VpnConnectionId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeVpnConnectionsResult' => [
            'type' => 'structure',
            'members' => ['VpnConnections' => ['shape' => 'VpnConnectionList', 'locationName' => 'vpnConnectionSet',],],
        ],
        'DescribeVpnGatewaysRequest' => [
            'type' => 'structure',
            'members' => [
                'Filters' => ['shape' => 'FilterList', 'locationName' => 'Filter',],
                'VpnGatewayIds' => ['shape' => 'VpnGatewayIdStringList', 'locationName' => 'VpnGatewayId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DescribeVpnGatewaysResult' => [
            'type' => 'structure',
            'members' => ['VpnGateways' => ['shape' => 'VpnGatewayList', 'locationName' => 'vpnGatewaySet',],],
        ],
        'DetachClassicLinkVpcRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId', 'VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'DetachClassicLinkVpcResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'DetachInternetGatewayRequest' => [
            'type' => 'structure',
            'required' => ['InternetGatewayId', 'VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InternetGatewayId' => ['shape' => 'String', 'locationName' => 'internetGatewayId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'DetachNetworkInterfaceRequest' => [
            'type' => 'structure',
            'required' => ['AttachmentId',],
            'members' => [
                'AttachmentId' => ['shape' => 'String', 'locationName' => 'attachmentId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Force' => ['shape' => 'Boolean', 'locationName' => 'force',],
            ],
        ],
        'DetachVolumeRequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'Device' => ['shape' => 'String',],
                'Force' => ['shape' => 'Boolean',],
                'InstanceId' => ['shape' => 'String',],
                'VolumeId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DetachVpnGatewayRequest' => [
            'type' => 'structure',
            'required' => ['VpcId', 'VpnGatewayId',],
            'members' => [
                'VpcId' => ['shape' => 'String',],
                'VpnGatewayId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DeviceType' => ['type' => 'string', 'enum' => ['ebs', 'instance-store',],],
        'DhcpConfiguration' => [
            'type' => 'structure',
            'members' => [
                'Key' => ['shape' => 'String', 'locationName' => 'key',],
                'Values' => ['shape' => 'DhcpConfigurationValueList', 'locationName' => 'valueSet',],
            ],
        ],
        'DhcpConfigurationList' => [
            'type' => 'list',
            'member' => ['shape' => 'DhcpConfiguration', 'locationName' => 'item',],
        ],
        'DhcpConfigurationValueList' => [
            'type' => 'list',
            'member' => ['shape' => 'AttributeValue', 'locationName' => 'item',],
        ],
        'DhcpOptions' => [
            'type' => 'structure',
            'members' => [
                'DhcpConfigurations' => [
                    'shape' => 'DhcpConfigurationList',
                    'locationName' => 'dhcpConfigurationSet',
                ],
                'DhcpOptionsId' => ['shape' => 'String', 'locationName' => 'dhcpOptionsId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'DhcpOptionsIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'DhcpOptionsId',],
        ],
        'DhcpOptionsList' => ['type' => 'list', 'member' => ['shape' => 'DhcpOptions', 'locationName' => 'item',],],
        'DisableVgwRoutePropagationRequest' => [
            'type' => 'structure',
            'required' => ['GatewayId', 'RouteTableId',],
            'members' => ['GatewayId' => ['shape' => 'String',], 'RouteTableId' => ['shape' => 'String',],],
        ],
        'DisableVpcClassicLinkDnsSupportRequest' => [
            'type' => 'structure',
            'members' => ['VpcId' => ['shape' => 'String',],],
        ],
        'DisableVpcClassicLinkDnsSupportResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'DisableVpcClassicLinkRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'DisableVpcClassicLinkResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'DisassociateAddressRequest' => [
            'type' => 'structure',
            'members' => [
                'AssociationId' => ['shape' => 'String',],
                'PublicIp' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DisassociateIamInstanceProfileRequest' => [
            'type' => 'structure',
            'required' => ['AssociationId',],
            'members' => ['AssociationId' => ['shape' => 'String',],],
        ],
        'DisassociateIamInstanceProfileResult' => [
            'type' => 'structure',
            'members' => [
                'IamInstanceProfileAssociation' => [
                    'shape' => 'IamInstanceProfileAssociation',
                    'locationName' => 'iamInstanceProfileAssociation',
                ],
            ],
        ],
        'DisassociateRouteTableRequest' => [
            'type' => 'structure',
            'required' => ['AssociationId',],
            'members' => [
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'DisassociateSubnetCidrBlockRequest' => [
            'type' => 'structure',
            'required' => ['AssociationId',],
            'members' => ['AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],],
        ],
        'DisassociateSubnetCidrBlockResult' => [
            'type' => 'structure',
            'members' => [
                'Ipv6CidrBlockAssociation' => [
                    'shape' => 'SubnetIpv6CidrBlockAssociation',
                    'locationName' => 'ipv6CidrBlockAssociation',
                ],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'DisassociateVpcCidrBlockRequest' => [
            'type' => 'structure',
            'required' => ['AssociationId',],
            'members' => ['AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],],
        ],
        'DisassociateVpcCidrBlockResult' => [
            'type' => 'structure',
            'members' => [
                'Ipv6CidrBlockAssociation' => [
                    'shape' => 'VpcIpv6CidrBlockAssociation',
                    'locationName' => 'ipv6CidrBlockAssociation',
                ],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'DiskImage' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String',],
                'Image' => ['shape' => 'DiskImageDetail',],
                'Volume' => ['shape' => 'VolumeDetail',],
            ],
        ],
        'DiskImageDescription' => [
            'type' => 'structure',
            'required' => ['Format', 'ImportManifestUrl', 'Size',],
            'members' => [
                'Checksum' => ['shape' => 'String', 'locationName' => 'checksum',],
                'Format' => ['shape' => 'DiskImageFormat', 'locationName' => 'format',],
                'ImportManifestUrl' => ['shape' => 'String', 'locationName' => 'importManifestUrl',],
                'Size' => ['shape' => 'Long', 'locationName' => 'size',],
            ],
        ],
        'DiskImageDetail' => [
            'type' => 'structure',
            'required' => ['Bytes', 'Format', 'ImportManifestUrl',],
            'members' => [
                'Bytes' => ['shape' => 'Long', 'locationName' => 'bytes',],
                'Format' => ['shape' => 'DiskImageFormat', 'locationName' => 'format',],
                'ImportManifestUrl' => ['shape' => 'String', 'locationName' => 'importManifestUrl',],
            ],
        ],
        'DiskImageFormat' => ['type' => 'string', 'enum' => ['VMDK', 'RAW', 'VHD',],],
        'DiskImageList' => ['type' => 'list', 'member' => ['shape' => 'DiskImage',],],
        'DiskImageVolumeDescription' => [
            'type' => 'structure',
            'required' => ['Id',],
            'members' => [
                'Id' => ['shape' => 'String', 'locationName' => 'id',],
                'Size' => ['shape' => 'Long', 'locationName' => 'size',],
            ],
        ],
        'DomainType' => ['type' => 'string', 'enum' => ['vpc', 'standard',],],
        'Double' => ['type' => 'double',],
        'EbsBlockDevice' => [
            'type' => 'structure',
            'members' => [
                'Encrypted' => ['shape' => 'Boolean', 'locationName' => 'encrypted',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
                'Iops' => ['shape' => 'Integer', 'locationName' => 'iops',],
                'SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],
                'VolumeSize' => ['shape' => 'Integer', 'locationName' => 'volumeSize',],
                'VolumeType' => ['shape' => 'VolumeType', 'locationName' => 'volumeType',],
            ],
        ],
        'EbsInstanceBlockDevice' => [
            'type' => 'structure',
            'members' => [
                'AttachTime' => ['shape' => 'DateTime', 'locationName' => 'attachTime',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
                'Status' => ['shape' => 'AttachmentStatus', 'locationName' => 'status',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
            ],
        ],
        'EbsInstanceBlockDeviceSpecification' => [
            'type' => 'structure',
            'members' => [
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
            ],
        ],
        'EgressOnlyInternetGateway' => [
            'type' => 'structure',
            'members' => [
                'Attachments' => [
                    'shape' => 'InternetGatewayAttachmentList',
                    'locationName' => 'attachmentSet',
                ],
                'EgressOnlyInternetGatewayId' => [
                    'shape' => 'EgressOnlyInternetGatewayId',
                    'locationName' => 'egressOnlyInternetGatewayId',
                ],
            ],
        ],
        'EgressOnlyInternetGatewayId' => ['type' => 'string',],
        'EgressOnlyInternetGatewayIdList' => [
            'type' => 'list',
            'member' => ['shape' => 'EgressOnlyInternetGatewayId', 'locationName' => 'item',],
        ],
        'EgressOnlyInternetGatewayList' => [
            'type' => 'list',
            'member' => ['shape' => 'EgressOnlyInternetGateway', 'locationName' => 'item',],
        ],
        'EnableVgwRoutePropagationRequest' => [
            'type' => 'structure',
            'required' => ['GatewayId', 'RouteTableId',],
            'members' => ['GatewayId' => ['shape' => 'String',], 'RouteTableId' => ['shape' => 'String',],],
        ],
        'EnableVolumeIORequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
            ],
        ],
        'EnableVpcClassicLinkDnsSupportRequest' => [
            'type' => 'structure',
            'members' => ['VpcId' => ['shape' => 'String',],],
        ],
        'EnableVpcClassicLinkDnsSupportResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'EnableVpcClassicLinkRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'EnableVpcClassicLinkResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'EventCode' => [
            'type' => 'string',
            'enum' => [
                'instance-reboot',
                'system-reboot',
                'system-maintenance',
                'instance-retirement',
                'instance-stop',
            ],
        ],
        'EventInformation' => [
            'type' => 'structure',
            'members' => [
                'EventDescription' => ['shape' => 'String', 'locationName' => 'eventDescription',],
                'EventSubType' => ['shape' => 'String', 'locationName' => 'eventSubType',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
            ],
        ],
        'EventType' => ['type' => 'string', 'enum' => ['instanceChange', 'fleetRequestChange', 'error',],],
        'ExcessCapacityTerminationPolicy' => ['type' => 'string', 'enum' => ['noTermination', 'default',],],
        'ExecutableByStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ExecutableBy',],
        ],
        'ExportEnvironment' => ['type' => 'string', 'enum' => ['citrix', 'vmware', 'microsoft',],],
        'ExportTask' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'ExportTaskId' => ['shape' => 'String', 'locationName' => 'exportTaskId',],
                'ExportToS3Task' => ['shape' => 'ExportToS3Task', 'locationName' => 'exportToS3',],
                'InstanceExportDetails' => ['shape' => 'InstanceExportDetails', 'locationName' => 'instanceExport',],
                'State' => ['shape' => 'ExportTaskState', 'locationName' => 'state',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
            ],
        ],
        'ExportTaskIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ExportTaskId',],
        ],
        'ExportTaskList' => ['type' => 'list', 'member' => ['shape' => 'ExportTask', 'locationName' => 'item',],],
        'ExportTaskState' => ['type' => 'string', 'enum' => ['active', 'cancelling', 'cancelled', 'completed',],],
        'ExportToS3Task' => [
            'type' => 'structure',
            'members' => [
                'ContainerFormat' => ['shape' => 'ContainerFormat', 'locationName' => 'containerFormat',],
                'DiskImageFormat' => ['shape' => 'DiskImageFormat', 'locationName' => 'diskImageFormat',],
                'S3Bucket' => ['shape' => 'String', 'locationName' => 's3Bucket',],
                'S3Key' => ['shape' => 'String', 'locationName' => 's3Key',],
            ],
        ],
        'ExportToS3TaskSpecification' => [
            'type' => 'structure',
            'members' => [
                'ContainerFormat' => ['shape' => 'ContainerFormat', 'locationName' => 'containerFormat',],
                'DiskImageFormat' => ['shape' => 'DiskImageFormat', 'locationName' => 'diskImageFormat',],
                'S3Bucket' => ['shape' => 'String', 'locationName' => 's3Bucket',],
                'S3Prefix' => ['shape' => 'String', 'locationName' => 's3Prefix',],
            ],
        ],
        'Filter' => [
            'type' => 'structure',
            'members' => [
                'Name' => ['shape' => 'String',],
                'Values' => ['shape' => 'ValueStringList', 'locationName' => 'Value',],
            ],
        ],
        'FilterList' => ['type' => 'list', 'member' => ['shape' => 'Filter', 'locationName' => 'Filter',],],
        'FleetType' => ['type' => 'string', 'enum' => ['request', 'maintain',],],
        'Float' => ['type' => 'float',],
        'FlowLog' => [
            'type' => 'structure',
            'members' => [
                'CreationTime' => ['shape' => 'DateTime', 'locationName' => 'creationTime',],
                'DeliverLogsErrorMessage' => ['shape' => 'String', 'locationName' => 'deliverLogsErrorMessage',],
                'DeliverLogsPermissionArn' => ['shape' => 'String', 'locationName' => 'deliverLogsPermissionArn',],
                'DeliverLogsStatus' => ['shape' => 'String', 'locationName' => 'deliverLogsStatus',],
                'FlowLogId' => ['shape' => 'String', 'locationName' => 'flowLogId',],
                'FlowLogStatus' => ['shape' => 'String', 'locationName' => 'flowLogStatus',],
                'LogGroupName' => ['shape' => 'String', 'locationName' => 'logGroupName',],
                'ResourceId' => ['shape' => 'String', 'locationName' => 'resourceId',],
                'TrafficType' => ['shape' => 'TrafficType', 'locationName' => 'trafficType',],
            ],
        ],
        'FlowLogSet' => ['type' => 'list', 'member' => ['shape' => 'FlowLog', 'locationName' => 'item',],],
        'FlowLogsResourceType' => ['type' => 'string', 'enum' => ['VPC', 'Subnet', 'NetworkInterface',],],
        'FpgaImage' => [
            'type' => 'structure',
            'members' => [
                'FpgaImageId' => ['shape' => 'String', 'locationName' => 'fpgaImageId',],
                'FpgaImageGlobalId' => ['shape' => 'String', 'locationName' => 'fpgaImageGlobalId',],
                'Name' => ['shape' => 'String', 'locationName' => 'name',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'ShellVersion' => ['shape' => 'String', 'locationName' => 'shellVersion',],
                'PciId' => ['shape' => 'PciId', 'locationName' => 'pciId',],
                'State' => ['shape' => 'FpgaImageState', 'locationName' => 'state',],
                'CreateTime' => ['shape' => 'DateTime', 'locationName' => 'createTime',],
                'UpdateTime' => ['shape' => 'DateTime', 'locationName' => 'updateTime',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'OwnerAlias' => ['shape' => 'String', 'locationName' => 'ownerAlias',],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tags',],
            ],
        ],
        'FpgaImageIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'FpgaImageList' => ['type' => 'list', 'member' => ['shape' => 'FpgaImage', 'locationName' => 'item',],],
        'FpgaImageState' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'FpgaImageStateCode', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'FpgaImageStateCode' => ['type' => 'string', 'enum' => ['pending', 'failed', 'available', 'unavailable',],],
        'GatewayType' => ['type' => 'string', 'enum' => ['ipsec.1',],],
        'GetConsoleOutputRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId',],
            'members' => [
                'InstanceId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'GetConsoleOutputResult' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Output' => ['shape' => 'String', 'locationName' => 'output',],
                'Timestamp' => ['shape' => 'DateTime', 'locationName' => 'timestamp',],
            ],
        ],
        'GetConsoleScreenshotRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'InstanceId' => ['shape' => 'String',],
                'WakeUp' => ['shape' => 'Boolean',],
            ],
        ],
        'GetConsoleScreenshotResult' => [
            'type' => 'structure',
            'members' => [
                'ImageData' => ['shape' => 'String', 'locationName' => 'imageData',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
            ],
        ],
        'GetHostReservationPurchasePreviewRequest' => [
            'type' => 'structure',
            'required' => ['HostIdSet', 'OfferingId',],
            'members' => ['HostIdSet' => ['shape' => 'RequestHostIdSet',], 'OfferingId' => ['shape' => 'String',],],
        ],
        'GetHostReservationPurchasePreviewResult' => [
            'type' => 'structure',
            'members' => [
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Purchase' => ['shape' => 'PurchaseSet', 'locationName' => 'purchase',],
                'TotalHourlyPrice' => ['shape' => 'String', 'locationName' => 'totalHourlyPrice',],
                'TotalUpfrontPrice' => ['shape' => 'String', 'locationName' => 'totalUpfrontPrice',],
            ],
        ],
        'GetPasswordDataRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId',],
            'members' => [
                'InstanceId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'GetPasswordDataResult' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'PasswordData' => ['shape' => 'String', 'locationName' => 'passwordData',],
                'Timestamp' => ['shape' => 'DateTime', 'locationName' => 'timestamp',],
            ],
        ],
        'GetReservedInstancesExchangeQuoteRequest' => [
            'type' => 'structure',
            'required' => ['ReservedInstanceIds',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'ReservedInstanceIds' => ['shape' => 'ReservedInstanceIdSet', 'locationName' => 'ReservedInstanceId',],
                'TargetConfigurations' => [
                    'shape' => 'TargetConfigurationRequestSet',
                    'locationName' => 'TargetConfiguration',
                ],
            ],
        ],
        'GetReservedInstancesExchangeQuoteResult' => [
            'type' => 'structure',
            'members' => [
                'CurrencyCode' => ['shape' => 'String', 'locationName' => 'currencyCode',],
                'IsValidExchange' => ['shape' => 'Boolean', 'locationName' => 'isValidExchange',],
                'OutputReservedInstancesWillExpireAt' => [
                    'shape' => 'DateTime',
                    'locationName' => 'outputReservedInstancesWillExpireAt',
                ],
                'PaymentDue' => ['shape' => 'String', 'locationName' => 'paymentDue',],
                'ReservedInstanceValueRollup' => [
                    'shape' => 'ReservationValue',
                    'locationName' => 'reservedInstanceValueRollup',
                ],
                'ReservedInstanceValueSet' => [
                    'shape' => 'ReservedInstanceReservationValueSet',
                    'locationName' => 'reservedInstanceValueSet',
                ],
                'TargetConfigurationValueRollup' => [
                    'shape' => 'ReservationValue',
                    'locationName' => 'targetConfigurationValueRollup',
                ],
                'TargetConfigurationValueSet' => [
                    'shape' => 'TargetReservationValueSet',
                    'locationName' => 'targetConfigurationValueSet',
                ],
                'ValidationFailureReason' => ['shape' => 'String', 'locationName' => 'validationFailureReason',],
            ],
        ],
        'GroupIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'groupId',],],
        'GroupIdentifier' => [
            'type' => 'structure',
            'members' => [
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
            ],
        ],
        'GroupIdentifierList' => [
            'type' => 'list',
            'member' => ['shape' => 'GroupIdentifier', 'locationName' => 'item',],
        ],
        'GroupIds' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'GroupNameStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'GroupName',],],
        'HistoryRecord' => [
            'type' => 'structure',
            'required' => ['EventInformation', 'EventType', 'Timestamp',],
            'members' => [
                'EventInformation' => ['shape' => 'EventInformation', 'locationName' => 'eventInformation',],
                'EventType' => ['shape' => 'EventType', 'locationName' => 'eventType',],
                'Timestamp' => ['shape' => 'DateTime', 'locationName' => 'timestamp',],
            ],
        ],
        'HistoryRecords' => ['type' => 'list', 'member' => ['shape' => 'HistoryRecord', 'locationName' => 'item',],],
        'Host' => [
            'type' => 'structure',
            'members' => [
                'AutoPlacement' => ['shape' => 'AutoPlacement', 'locationName' => 'autoPlacement',],
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'AvailableCapacity' => ['shape' => 'AvailableCapacity', 'locationName' => 'availableCapacity',],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'HostId' => ['shape' => 'String', 'locationName' => 'hostId',],
                'HostProperties' => ['shape' => 'HostProperties', 'locationName' => 'hostProperties',],
                'HostReservationId' => ['shape' => 'String', 'locationName' => 'hostReservationId',],
                'Instances' => ['shape' => 'HostInstanceList', 'locationName' => 'instances',],
                'State' => ['shape' => 'AllocationState', 'locationName' => 'state',],
            ],
        ],
        'HostInstance' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
            ],
        ],
        'HostInstanceList' => ['type' => 'list', 'member' => ['shape' => 'HostInstance', 'locationName' => 'item',],],
        'HostList' => ['type' => 'list', 'member' => ['shape' => 'Host', 'locationName' => 'item',],],
        'HostOffering' => [
            'type' => 'structure',
            'members' => [
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Duration' => ['shape' => 'Integer', 'locationName' => 'duration',],
                'HourlyPrice' => ['shape' => 'String', 'locationName' => 'hourlyPrice',],
                'InstanceFamily' => ['shape' => 'String', 'locationName' => 'instanceFamily',],
                'OfferingId' => ['shape' => 'String', 'locationName' => 'offeringId',],
                'PaymentOption' => ['shape' => 'PaymentOption', 'locationName' => 'paymentOption',],
                'UpfrontPrice' => ['shape' => 'String', 'locationName' => 'upfrontPrice',],
            ],
        ],
        'HostOfferingSet' => ['type' => 'list', 'member' => ['shape' => 'HostOffering',],],
        'HostProperties' => [
            'type' => 'structure',
            'members' => [
                'Cores' => ['shape' => 'Integer', 'locationName' => 'cores',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
                'Sockets' => ['shape' => 'Integer', 'locationName' => 'sockets',],
                'TotalVCpus' => ['shape' => 'Integer', 'locationName' => 'totalVCpus',],
            ],
        ],
        'HostReservation' => [
            'type' => 'structure',
            'members' => [
                'Count' => ['shape' => 'Integer', 'locationName' => 'count',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Duration' => ['shape' => 'Integer', 'locationName' => 'duration',],
                'End' => ['shape' => 'DateTime', 'locationName' => 'end',],
                'HostIdSet' => ['shape' => 'ResponseHostIdSet', 'locationName' => 'hostIdSet',],
                'HostReservationId' => ['shape' => 'String', 'locationName' => 'hostReservationId',],
                'HourlyPrice' => ['shape' => 'String', 'locationName' => 'hourlyPrice',],
                'InstanceFamily' => ['shape' => 'String', 'locationName' => 'instanceFamily',],
                'OfferingId' => ['shape' => 'String', 'locationName' => 'offeringId',],
                'PaymentOption' => ['shape' => 'PaymentOption', 'locationName' => 'paymentOption',],
                'Start' => ['shape' => 'DateTime', 'locationName' => 'start',],
                'State' => ['shape' => 'ReservationState', 'locationName' => 'state',],
                'UpfrontPrice' => ['shape' => 'String', 'locationName' => 'upfrontPrice',],
            ],
        ],
        'HostReservationIdSet' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'HostReservationSet' => ['type' => 'list', 'member' => ['shape' => 'HostReservation',],],
        'HostTenancy' => ['type' => 'string', 'enum' => ['dedicated', 'host',],],
        'HypervisorType' => ['type' => 'string', 'enum' => ['ovm', 'xen',],],
        'IamInstanceProfile' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => 'String', 'locationName' => 'arn',],
                'Id' => ['shape' => 'String', 'locationName' => 'id',],
            ],
        ],
        'IamInstanceProfileAssociation' => [
            'type' => 'structure',
            'members' => [
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'IamInstanceProfile' => ['shape' => 'IamInstanceProfile', 'locationName' => 'iamInstanceProfile',],
                'State' => ['shape' => 'IamInstanceProfileAssociationState', 'locationName' => 'state',],
                'Timestamp' => ['shape' => 'DateTime', 'locationName' => 'timestamp',],
            ],
        ],
        'IamInstanceProfileAssociationSet' => [
            'type' => 'list',
            'member' => ['shape' => 'IamInstanceProfileAssociation', 'locationName' => 'item',],
        ],
        'IamInstanceProfileAssociationState' => [
            'type' => 'string',
            'enum' => ['associating', 'associated', 'disassociating', 'disassociated',],
        ],
        'IamInstanceProfileSpecification' => [
            'type' => 'structure',
            'members' => [
                'Arn' => ['shape' => 'String', 'locationName' => 'arn',],
                'Name' => ['shape' => 'String', 'locationName' => 'name',],
            ],
        ],
        'IcmpTypeCode' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'Integer', 'locationName' => 'code',],
                'Type' => ['shape' => 'Integer', 'locationName' => 'type',],
            ],
        ],
        'IdFormat' => [
            'type' => 'structure',
            'members' => [
                'Deadline' => ['shape' => 'DateTime', 'locationName' => 'deadline',],
                'Resource' => ['shape' => 'String', 'locationName' => 'resource',],
                'UseLongIds' => ['shape' => 'Boolean', 'locationName' => 'useLongIds',],
            ],
        ],
        'IdFormatList' => ['type' => 'list', 'member' => ['shape' => 'IdFormat', 'locationName' => 'item',],],
        'Image' => [
            'type' => 'structure',
            'members' => [
                'Architecture' => ['shape' => 'ArchitectureValues', 'locationName' => 'architecture',],
                'CreationDate' => ['shape' => 'String', 'locationName' => 'creationDate',],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'ImageLocation' => ['shape' => 'String', 'locationName' => 'imageLocation',],
                'ImageType' => ['shape' => 'ImageTypeValues', 'locationName' => 'imageType',],
                'Public' => ['shape' => 'Boolean', 'locationName' => 'isPublic',],
                'KernelId' => ['shape' => 'String', 'locationName' => 'kernelId',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'imageOwnerId',],
                'Platform' => ['shape' => 'PlatformValues', 'locationName' => 'platform',],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'RamdiskId' => ['shape' => 'String', 'locationName' => 'ramdiskId',],
                'State' => ['shape' => 'ImageState', 'locationName' => 'imageState',],
                'BlockDeviceMappings' => ['shape' => 'BlockDeviceMappingList', 'locationName' => 'blockDeviceMapping',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'EnaSupport' => ['shape' => 'Boolean', 'locationName' => 'enaSupport',],
                'Hypervisor' => ['shape' => 'HypervisorType', 'locationName' => 'hypervisor',],
                'ImageOwnerAlias' => ['shape' => 'String', 'locationName' => 'imageOwnerAlias',],
                'Name' => ['shape' => 'String', 'locationName' => 'name',],
                'RootDeviceName' => ['shape' => 'String', 'locationName' => 'rootDeviceName',],
                'RootDeviceType' => ['shape' => 'DeviceType', 'locationName' => 'rootDeviceType',],
                'SriovNetSupport' => ['shape' => 'String', 'locationName' => 'sriovNetSupport',],
                'StateReason' => ['shape' => 'StateReason', 'locationName' => 'stateReason',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VirtualizationType' => ['shape' => 'VirtualizationType', 'locationName' => 'virtualizationType',],
            ],
        ],
        'ImageAttribute' => [
            'type' => 'structure',
            'members' => [
                'BlockDeviceMappings' => [
                    'shape' => 'BlockDeviceMappingList',
                    'locationName' => 'blockDeviceMapping',
                ],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'LaunchPermissions' => ['shape' => 'LaunchPermissionList', 'locationName' => 'launchPermission',],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'Description' => ['shape' => 'AttributeValue', 'locationName' => 'description',],
                'KernelId' => ['shape' => 'AttributeValue', 'locationName' => 'kernel',],
                'RamdiskId' => ['shape' => 'AttributeValue', 'locationName' => 'ramdisk',],
                'SriovNetSupport' => ['shape' => 'AttributeValue', 'locationName' => 'sriovNetSupport',],
            ],
        ],
        'ImageAttributeName' => [
            'type' => 'string',
            'enum' => [
                'description',
                'kernel',
                'ramdisk',
                'launchPermission',
                'productCodes',
                'blockDeviceMapping',
                'sriovNetSupport',
            ],
        ],
        'ImageDiskContainer' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String',],
                'DeviceName' => ['shape' => 'String',],
                'Format' => ['shape' => 'String',],
                'SnapshotId' => ['shape' => 'String',],
                'Url' => ['shape' => 'String',],
                'UserBucket' => ['shape' => 'UserBucket',],
            ],
        ],
        'ImageDiskContainerList' => [
            'type' => 'list',
            'member' => ['shape' => 'ImageDiskContainer', 'locationName' => 'item',],
        ],
        'ImageIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'ImageId',],],
        'ImageList' => ['type' => 'list', 'member' => ['shape' => 'Image', 'locationName' => 'item',],],
        'ImageState' => [
            'type' => 'string',
            'enum' => ['pending', 'available', 'invalid', 'deregistered', 'transient', 'failed', 'error',],
        ],
        'ImageTypeValues' => ['type' => 'string', 'enum' => ['machine', 'kernel', 'ramdisk',],],
        'ImportImageRequest' => [
            'type' => 'structure',
            'members' => [
                'Architecture' => ['shape' => 'String',],
                'ClientData' => ['shape' => 'ClientData',],
                'ClientToken' => ['shape' => 'String',],
                'Description' => ['shape' => 'String',],
                'DiskContainers' => ['shape' => 'ImageDiskContainerList', 'locationName' => 'DiskContainer',],
                'DryRun' => ['shape' => 'Boolean',],
                'Hypervisor' => ['shape' => 'String',],
                'LicenseType' => ['shape' => 'String',],
                'Platform' => ['shape' => 'String',],
                'RoleName' => ['shape' => 'String',],
            ],
        ],
        'ImportImageResult' => [
            'type' => 'structure',
            'members' => [
                'Architecture' => ['shape' => 'String', 'locationName' => 'architecture',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Hypervisor' => ['shape' => 'String', 'locationName' => 'hypervisor',],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'ImportTaskId' => ['shape' => 'String', 'locationName' => 'importTaskId',],
                'LicenseType' => ['shape' => 'String', 'locationName' => 'licenseType',],
                'Platform' => ['shape' => 'String', 'locationName' => 'platform',],
                'Progress' => ['shape' => 'String', 'locationName' => 'progress',],
                'SnapshotDetails' => ['shape' => 'SnapshotDetailList', 'locationName' => 'snapshotDetailSet',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
            ],
        ],
        'ImportImageTask' => [
            'type' => 'structure',
            'members' => [
                'Architecture' => ['shape' => 'String', 'locationName' => 'architecture',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Hypervisor' => ['shape' => 'String', 'locationName' => 'hypervisor',],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'ImportTaskId' => ['shape' => 'String', 'locationName' => 'importTaskId',],
                'LicenseType' => ['shape' => 'String', 'locationName' => 'licenseType',],
                'Platform' => ['shape' => 'String', 'locationName' => 'platform',],
                'Progress' => ['shape' => 'String', 'locationName' => 'progress',],
                'SnapshotDetails' => ['shape' => 'SnapshotDetailList', 'locationName' => 'snapshotDetailSet',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
            ],
        ],
        'ImportImageTaskList' => [
            'type' => 'list',
            'member' => ['shape' => 'ImportImageTask', 'locationName' => 'item',],
        ],
        'ImportInstanceLaunchSpecification' => [
            'type' => 'structure',
            'members' => [
                'AdditionalInfo' => ['shape' => 'String', 'locationName' => 'additionalInfo',],
                'Architecture' => ['shape' => 'ArchitectureValues', 'locationName' => 'architecture',],
                'GroupIds' => ['shape' => 'SecurityGroupIdStringList', 'locationName' => 'GroupId',],
                'GroupNames' => ['shape' => 'SecurityGroupStringList', 'locationName' => 'GroupName',],
                'InstanceInitiatedShutdownBehavior' => [
                    'shape' => 'ShutdownBehavior',
                    'locationName' => 'instanceInitiatedShutdownBehavior',
                ],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'Monitoring' => ['shape' => 'Boolean', 'locationName' => 'monitoring',],
                'Placement' => ['shape' => 'Placement', 'locationName' => 'placement',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'UserData' => ['shape' => 'UserData', 'locationName' => 'userData',],
            ],
        ],
        'ImportInstanceRequest' => [
            'type' => 'structure',
            'required' => ['Platform',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DiskImages' => ['shape' => 'DiskImageList', 'locationName' => 'diskImage',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'LaunchSpecification' => [
                    'shape' => 'ImportInstanceLaunchSpecification',
                    'locationName' => 'launchSpecification',
                ],
                'Platform' => ['shape' => 'PlatformValues', 'locationName' => 'platform',],
            ],
        ],
        'ImportInstanceResult' => [
            'type' => 'structure',
            'members' => ['ConversionTask' => ['shape' => 'ConversionTask', 'locationName' => 'conversionTask',],],
        ],
        'ImportInstanceTaskDetails' => [
            'type' => 'structure',
            'required' => ['Volumes',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Platform' => ['shape' => 'PlatformValues', 'locationName' => 'platform',],
                'Volumes' => ['shape' => 'ImportInstanceVolumeDetailSet', 'locationName' => 'volumes',],
            ],
        ],
        'ImportInstanceVolumeDetailItem' => [
            'type' => 'structure',
            'required' => ['AvailabilityZone', 'BytesConverted', 'Image', 'Status', 'Volume',],
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'BytesConverted' => ['shape' => 'Long', 'locationName' => 'bytesConverted',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Image' => ['shape' => 'DiskImageDescription', 'locationName' => 'image',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'Volume' => ['shape' => 'DiskImageVolumeDescription', 'locationName' => 'volume',],
            ],
        ],
        'ImportInstanceVolumeDetailSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ImportInstanceVolumeDetailItem', 'locationName' => 'item',],
        ],
        'ImportKeyPairRequest' => [
            'type' => 'structure',
            'required' => ['KeyName', 'PublicKeyMaterial',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
                'PublicKeyMaterial' => ['shape' => 'Blob', 'locationName' => 'publicKeyMaterial',],
            ],
        ],
        'ImportKeyPairResult' => [
            'type' => 'structure',
            'members' => [
                'KeyFingerprint' => ['shape' => 'String', 'locationName' => 'keyFingerprint',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
            ],
        ],
        'ImportSnapshotRequest' => [
            'type' => 'structure',
            'members' => [
                'ClientData' => ['shape' => 'ClientData',],
                'ClientToken' => ['shape' => 'String',],
                'Description' => ['shape' => 'String',],
                'DiskContainer' => ['shape' => 'SnapshotDiskContainer',],
                'DryRun' => ['shape' => 'Boolean',],
                'RoleName' => ['shape' => 'String',],
            ],
        ],
        'ImportSnapshotResult' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'ImportTaskId' => ['shape' => 'String', 'locationName' => 'importTaskId',],
                'SnapshotTaskDetail' => ['shape' => 'SnapshotTaskDetail', 'locationName' => 'snapshotTaskDetail',],
            ],
        ],
        'ImportSnapshotTask' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'ImportTaskId' => ['shape' => 'String', 'locationName' => 'importTaskId',],
                'SnapshotTaskDetail' => ['shape' => 'SnapshotTaskDetail', 'locationName' => 'snapshotTaskDetail',],
            ],
        ],
        'ImportSnapshotTaskList' => [
            'type' => 'list',
            'member' => ['shape' => 'ImportSnapshotTask', 'locationName' => 'item',],
        ],
        'ImportTaskIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'ImportTaskId',],],
        'ImportVolumeRequest' => [
            'type' => 'structure',
            'required' => ['AvailabilityZone', 'Image', 'Volume',],
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Image' => ['shape' => 'DiskImageDetail', 'locationName' => 'image',],
                'Volume' => ['shape' => 'VolumeDetail', 'locationName' => 'volume',],
            ],
        ],
        'ImportVolumeResult' => [
            'type' => 'structure',
            'members' => ['ConversionTask' => ['shape' => 'ConversionTask', 'locationName' => 'conversionTask',],],
        ],
        'ImportVolumeTaskDetails' => [
            'type' => 'structure',
            'required' => ['AvailabilityZone', 'BytesConverted', 'Image', 'Volume',],
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'BytesConverted' => ['shape' => 'Long', 'locationName' => 'bytesConverted',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Image' => ['shape' => 'DiskImageDescription', 'locationName' => 'image',],
                'Volume' => ['shape' => 'DiskImageVolumeDescription', 'locationName' => 'volume',],
            ],
        ],
        'Instance' => [
            'type' => 'structure',
            'members' => [
                'AmiLaunchIndex' => ['shape' => 'Integer', 'locationName' => 'amiLaunchIndex',],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'KernelId' => ['shape' => 'String', 'locationName' => 'kernelId',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
                'LaunchTime' => ['shape' => 'DateTime', 'locationName' => 'launchTime',],
                'Monitoring' => ['shape' => 'Monitoring', 'locationName' => 'monitoring',],
                'Placement' => ['shape' => 'Placement', 'locationName' => 'placement',],
                'Platform' => ['shape' => 'PlatformValues', 'locationName' => 'platform',],
                'PrivateDnsName' => ['shape' => 'String', 'locationName' => 'privateDnsName',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'PublicDnsName' => ['shape' => 'String', 'locationName' => 'dnsName',],
                'PublicIpAddress' => ['shape' => 'String', 'locationName' => 'ipAddress',],
                'RamdiskId' => ['shape' => 'String', 'locationName' => 'ramdiskId',],
                'State' => ['shape' => 'InstanceState', 'locationName' => 'instanceState',],
                'StateTransitionReason' => ['shape' => 'String', 'locationName' => 'reason',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
                'Architecture' => ['shape' => 'ArchitectureValues', 'locationName' => 'architecture',],
                'BlockDeviceMappings' => [
                    'shape' => 'InstanceBlockDeviceMappingList',
                    'locationName' => 'blockDeviceMapping',
                ],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'EbsOptimized' => ['shape' => 'Boolean', 'locationName' => 'ebsOptimized',],
                'EnaSupport' => ['shape' => 'Boolean', 'locationName' => 'enaSupport',],
                'Hypervisor' => ['shape' => 'HypervisorType', 'locationName' => 'hypervisor',],
                'IamInstanceProfile' => ['shape' => 'IamInstanceProfile', 'locationName' => 'iamInstanceProfile',],
                'InstanceLifecycle' => ['shape' => 'InstanceLifecycleType', 'locationName' => 'instanceLifecycle',],
                'NetworkInterfaces' => [
                    'shape' => 'InstanceNetworkInterfaceList',
                    'locationName' => 'networkInterfaceSet',
                ],
                'RootDeviceName' => ['shape' => 'String', 'locationName' => 'rootDeviceName',],
                'RootDeviceType' => ['shape' => 'DeviceType', 'locationName' => 'rootDeviceType',],
                'SecurityGroups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'SourceDestCheck' => ['shape' => 'Boolean', 'locationName' => 'sourceDestCheck',],
                'SpotInstanceRequestId' => ['shape' => 'String', 'locationName' => 'spotInstanceRequestId',],
                'SriovNetSupport' => ['shape' => 'String', 'locationName' => 'sriovNetSupport',],
                'StateReason' => ['shape' => 'StateReason', 'locationName' => 'stateReason',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VirtualizationType' => ['shape' => 'VirtualizationType', 'locationName' => 'virtualizationType',],
            ],
        ],
        'InstanceAttribute' => [
            'type' => 'structure',
            'members' => [
                'Groups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'BlockDeviceMappings' => [
                    'shape' => 'InstanceBlockDeviceMappingList',
                    'locationName' => 'blockDeviceMapping',
                ],
                'DisableApiTermination' => [
                    'shape' => 'AttributeBooleanValue',
                    'locationName' => 'disableApiTermination',
                ],
                'EnaSupport' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'enaSupport',],
                'EbsOptimized' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'ebsOptimized',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceInitiatedShutdownBehavior' => [
                    'shape' => 'AttributeValue',
                    'locationName' => 'instanceInitiatedShutdownBehavior',
                ],
                'InstanceType' => ['shape' => 'AttributeValue', 'locationName' => 'instanceType',],
                'KernelId' => ['shape' => 'AttributeValue', 'locationName' => 'kernel',],
                'ProductCodes' => ['shape' => 'ProductCodeList', 'locationName' => 'productCodes',],
                'RamdiskId' => ['shape' => 'AttributeValue', 'locationName' => 'ramdisk',],
                'RootDeviceName' => ['shape' => 'AttributeValue', 'locationName' => 'rootDeviceName',],
                'SourceDestCheck' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'sourceDestCheck',],
                'SriovNetSupport' => ['shape' => 'AttributeValue', 'locationName' => 'sriovNetSupport',],
                'UserData' => ['shape' => 'AttributeValue', 'locationName' => 'userData',],
            ],
        ],
        'InstanceAttributeName' => [
            'type' => 'string',
            'enum' => [
                'instanceType',
                'kernel',
                'ramdisk',
                'userData',
                'disableApiTermination',
                'instanceInitiatedShutdownBehavior',
                'rootDeviceName',
                'blockDeviceMapping',
                'productCodes',
                'sourceDestCheck',
                'groupSet',
                'ebsOptimized',
                'sriovNetSupport',
                'enaSupport',
            ],
        ],
        'InstanceBlockDeviceMapping' => [
            'type' => 'structure',
            'members' => [
                'DeviceName' => ['shape' => 'String', 'locationName' => 'deviceName',],
                'Ebs' => ['shape' => 'EbsInstanceBlockDevice', 'locationName' => 'ebs',],
            ],
        ],
        'InstanceBlockDeviceMappingList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceBlockDeviceMapping', 'locationName' => 'item',],
        ],
        'InstanceBlockDeviceMappingSpecification' => [
            'type' => 'structure',
            'members' => [
                'DeviceName' => ['shape' => 'String', 'locationName' => 'deviceName',],
                'Ebs' => ['shape' => 'EbsInstanceBlockDeviceSpecification', 'locationName' => 'ebs',],
                'NoDevice' => ['shape' => 'String', 'locationName' => 'noDevice',],
                'VirtualName' => ['shape' => 'String', 'locationName' => 'virtualName',],
            ],
        ],
        'InstanceBlockDeviceMappingSpecificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceBlockDeviceMappingSpecification', 'locationName' => 'item',],
        ],
        'InstanceCapacity' => [
            'type' => 'structure',
            'members' => [
                'AvailableCapacity' => ['shape' => 'Integer', 'locationName' => 'availableCapacity',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
                'TotalCapacity' => ['shape' => 'Integer', 'locationName' => 'totalCapacity',],
            ],
        ],
        'InstanceCount' => [
            'type' => 'structure',
            'members' => [
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'State' => ['shape' => 'ListingState', 'locationName' => 'state',],
            ],
        ],
        'InstanceCountList' => ['type' => 'list', 'member' => ['shape' => 'InstanceCount', 'locationName' => 'item',],],
        'InstanceExportDetails' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'TargetEnvironment' => ['shape' => 'ExportEnvironment', 'locationName' => 'targetEnvironment',],
            ],
        ],
        'InstanceHealthStatus' => ['type' => 'string', 'enum' => ['healthy', 'unhealthy',],],
        'InstanceIdSet' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'InstanceIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'InstanceId',],
        ],
        'InstanceIpv6Address' => [
            'type' => 'structure',
            'members' => ['Ipv6Address' => ['shape' => 'String', 'locationName' => 'ipv6Address',],],
        ],
        'InstanceIpv6AddressList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceIpv6Address', 'locationName' => 'item',],
        ],
        'InstanceLifecycleType' => ['type' => 'string', 'enum' => ['spot', 'scheduled',],],
        'InstanceList' => ['type' => 'list', 'member' => ['shape' => 'Instance', 'locationName' => 'item',],],
        'InstanceMonitoring' => [
            'type' => 'structure',
            'members' => [
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Monitoring' => ['shape' => 'Monitoring', 'locationName' => 'monitoring',],
            ],
        ],
        'InstanceMonitoringList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceMonitoring', 'locationName' => 'item',],
        ],
        'InstanceNetworkInterface' => [
            'type' => 'structure',
            'members' => [
                'Association' => ['shape' => 'InstanceNetworkInterfaceAssociation', 'locationName' => 'association',],
                'Attachment' => ['shape' => 'InstanceNetworkInterfaceAttachment', 'locationName' => 'attachment',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Groups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'Ipv6Addresses' => ['shape' => 'InstanceIpv6AddressList', 'locationName' => 'ipv6AddressesSet',],
                'MacAddress' => ['shape' => 'String', 'locationName' => 'macAddress',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'PrivateDnsName' => ['shape' => 'String', 'locationName' => 'privateDnsName',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'PrivateIpAddresses' => [
                    'shape' => 'InstancePrivateIpAddressList',
                    'locationName' => 'privateIpAddressesSet',
                ],
                'SourceDestCheck' => ['shape' => 'Boolean', 'locationName' => 'sourceDestCheck',],
                'Status' => ['shape' => 'NetworkInterfaceStatus', 'locationName' => 'status',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'InstanceNetworkInterfaceAssociation' => [
            'type' => 'structure',
            'members' => [
                'IpOwnerId' => ['shape' => 'String', 'locationName' => 'ipOwnerId',],
                'PublicDnsName' => ['shape' => 'String', 'locationName' => 'publicDnsName',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
            ],
        ],
        'InstanceNetworkInterfaceAttachment' => [
            'type' => 'structure',
            'members' => [
                'AttachTime' => ['shape' => 'DateTime', 'locationName' => 'attachTime',],
                'AttachmentId' => ['shape' => 'String', 'locationName' => 'attachmentId',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
                'DeviceIndex' => ['shape' => 'Integer', 'locationName' => 'deviceIndex',],
                'Status' => ['shape' => 'AttachmentStatus', 'locationName' => 'status',],
            ],
        ],
        'InstanceNetworkInterfaceList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceNetworkInterface', 'locationName' => 'item',],
        ],
        'InstanceNetworkInterfaceSpecification' => [
            'type' => 'structure',
            'members' => [
                'AssociatePublicIpAddress' => ['shape' => 'Boolean', 'locationName' => 'associatePublicIpAddress',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DeviceIndex' => ['shape' => 'Integer', 'locationName' => 'deviceIndex',],
                'Groups' => ['shape' => 'SecurityGroupIdStringList', 'locationName' => 'SecurityGroupId',],
                'Ipv6AddressCount' => ['shape' => 'Integer', 'locationName' => 'ipv6AddressCount',],
                'Ipv6Addresses' => [
                    'shape' => 'InstanceIpv6AddressList',
                    'locationName' => 'ipv6AddressesSet',
                    'queryName' => 'Ipv6Addresses',
                ],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'PrivateIpAddresses' => [
                    'shape' => 'PrivateIpAddressSpecificationList',
                    'locationName' => 'privateIpAddressesSet',
                    'queryName' => 'PrivateIpAddresses',
                ],
                'SecondaryPrivateIpAddressCount' => [
                    'shape' => 'Integer',
                    'locationName' => 'secondaryPrivateIpAddressCount',
                ],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'InstanceNetworkInterfaceSpecificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceNetworkInterfaceSpecification', 'locationName' => 'item',],
        ],
        'InstancePrivateIpAddress' => [
            'type' => 'structure',
            'members' => [
                'Association' => [
                    'shape' => 'InstanceNetworkInterfaceAssociation',
                    'locationName' => 'association',
                ],
                'Primary' => ['shape' => 'Boolean', 'locationName' => 'primary',],
                'PrivateDnsName' => ['shape' => 'String', 'locationName' => 'privateDnsName',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
            ],
        ],
        'InstancePrivateIpAddressList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstancePrivateIpAddress', 'locationName' => 'item',],
        ],
        'InstanceState' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'Integer', 'locationName' => 'code',],
                'Name' => ['shape' => 'InstanceStateName', 'locationName' => 'name',],
            ],
        ],
        'InstanceStateChange' => [
            'type' => 'structure',
            'members' => [
                'CurrentState' => ['shape' => 'InstanceState', 'locationName' => 'currentState',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'PreviousState' => ['shape' => 'InstanceState', 'locationName' => 'previousState',],
            ],
        ],
        'InstanceStateChangeList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceStateChange', 'locationName' => 'item',],
        ],
        'InstanceStateName' => [
            'type' => 'string',
            'enum' => ['pending', 'running', 'shutting-down', 'terminated', 'stopping', 'stopped',],
        ],
        'InstanceStatus' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Events' => ['shape' => 'InstanceStatusEventList', 'locationName' => 'eventsSet',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceState' => ['shape' => 'InstanceState', 'locationName' => 'instanceState',],
                'InstanceStatus' => ['shape' => 'InstanceStatusSummary', 'locationName' => 'instanceStatus',],
                'SystemStatus' => ['shape' => 'InstanceStatusSummary', 'locationName' => 'systemStatus',],
            ],
        ],
        'InstanceStatusDetails' => [
            'type' => 'structure',
            'members' => [
                'ImpairedSince' => ['shape' => 'DateTime', 'locationName' => 'impairedSince',],
                'Name' => ['shape' => 'StatusName', 'locationName' => 'name',],
                'Status' => ['shape' => 'StatusType', 'locationName' => 'status',],
            ],
        ],
        'InstanceStatusDetailsList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceStatusDetails', 'locationName' => 'item',],
        ],
        'InstanceStatusEvent' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'EventCode', 'locationName' => 'code',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'NotAfter' => ['shape' => 'DateTime', 'locationName' => 'notAfter',],
                'NotBefore' => ['shape' => 'DateTime', 'locationName' => 'notBefore',],
            ],
        ],
        'InstanceStatusEventList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceStatusEvent', 'locationName' => 'item',],
        ],
        'InstanceStatusList' => [
            'type' => 'list',
            'member' => ['shape' => 'InstanceStatus', 'locationName' => 'item',],
        ],
        'InstanceStatusSummary' => [
            'type' => 'structure',
            'members' => [
                'Details' => ['shape' => 'InstanceStatusDetailsList', 'locationName' => 'details',],
                'Status' => ['shape' => 'SummaryStatus', 'locationName' => 'status',],
            ],
        ],
        'InstanceType' => [
            'type' => 'string',
            'enum' => [
                't1.micro',
                't2.nano',
                't2.micro',
                't2.small',
                't2.medium',
                't2.large',
                't2.xlarge',
                't2.2xlarge',
                'm1.small',
                'm1.medium',
                'm1.large',
                'm1.xlarge',
                'm3.medium',
                'm3.large',
                'm3.xlarge',
                'm3.2xlarge',
                'm4.large',
                'm4.xlarge',
                'm4.2xlarge',
                'm4.4xlarge',
                'm4.10xlarge',
                'm4.16xlarge',
                'm2.xlarge',
                'm2.2xlarge',
                'm2.4xlarge',
                'cr1.8xlarge',
                'r3.large',
                'r3.xlarge',
                'r3.2xlarge',
                'r3.4xlarge',
                'r3.8xlarge',
                'r4.large',
                'r4.xlarge',
                'r4.2xlarge',
                'r4.4xlarge',
                'r4.8xlarge',
                'r4.16xlarge',
                'x1.16xlarge',
                'x1.32xlarge',
                'i2.xlarge',
                'i2.2xlarge',
                'i2.4xlarge',
                'i2.8xlarge',
                'i3.large',
                'i3.xlarge',
                'i3.2xlarge',
                'i3.4xlarge',
                'i3.8xlarge',
                'i3.16xlarge',
                'hi1.4xlarge',
                'hs1.8xlarge',
                'c1.medium',
                'c1.xlarge',
                'c3.large',
                'c3.xlarge',
                'c3.2xlarge',
                'c3.4xlarge',
                'c3.8xlarge',
                'c4.large',
                'c4.xlarge',
                'c4.2xlarge',
                'c4.4xlarge',
                'c4.8xlarge',
                'cc1.4xlarge',
                'cc2.8xlarge',
                'g2.2xlarge',
                'g2.8xlarge',
                'cg1.4xlarge',
                'p2.xlarge',
                'p2.8xlarge',
                'p2.16xlarge',
                'd2.xlarge',
                'd2.2xlarge',
                'd2.4xlarge',
                'd2.8xlarge',
                'f1.2xlarge',
                'f1.16xlarge',
            ],
        ],
        'InstanceTypeList' => ['type' => 'list', 'member' => ['shape' => 'InstanceType',],],
        'Integer' => ['type' => 'integer',],
        'InternetGateway' => [
            'type' => 'structure',
            'members' => [
                'Attachments' => [
                    'shape' => 'InternetGatewayAttachmentList',
                    'locationName' => 'attachmentSet',
                ],
                'InternetGatewayId' => ['shape' => 'String', 'locationName' => 'internetGatewayId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'InternetGatewayAttachment' => [
            'type' => 'structure',
            'members' => [
                'State' => ['shape' => 'AttachmentStatus', 'locationName' => 'state',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'InternetGatewayAttachmentList' => [
            'type' => 'list',
            'member' => ['shape' => 'InternetGatewayAttachment', 'locationName' => 'item',],
        ],
        'InternetGatewayList' => [
            'type' => 'list',
            'member' => ['shape' => 'InternetGateway', 'locationName' => 'item',],
        ],
        'IpPermission' => [
            'type' => 'structure',
            'members' => [
                'FromPort' => ['shape' => 'Integer', 'locationName' => 'fromPort',],
                'IpProtocol' => ['shape' => 'String', 'locationName' => 'ipProtocol',],
                'IpRanges' => ['shape' => 'IpRangeList', 'locationName' => 'ipRanges',],
                'Ipv6Ranges' => ['shape' => 'Ipv6RangeList', 'locationName' => 'ipv6Ranges',],
                'PrefixListIds' => ['shape' => 'PrefixListIdList', 'locationName' => 'prefixListIds',],
                'ToPort' => ['shape' => 'Integer', 'locationName' => 'toPort',],
                'UserIdGroupPairs' => ['shape' => 'UserIdGroupPairList', 'locationName' => 'groups',],
            ],
        ],
        'IpPermissionList' => ['type' => 'list', 'member' => ['shape' => 'IpPermission', 'locationName' => 'item',],],
        'IpRange' => [
            'type' => 'structure',
            'members' => ['CidrIp' => ['shape' => 'String', 'locationName' => 'cidrIp',],],
        ],
        'IpRangeList' => ['type' => 'list', 'member' => ['shape' => 'IpRange', 'locationName' => 'item',],],
        'IpRanges' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'Ipv6Address' => ['type' => 'string',],
        'Ipv6AddressList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'Ipv6CidrBlock' => [
            'type' => 'structure',
            'members' => ['Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],],
        ],
        'Ipv6CidrBlockSet' => ['type' => 'list', 'member' => ['shape' => 'Ipv6CidrBlock', 'locationName' => 'item',],],
        'Ipv6Range' => [
            'type' => 'structure',
            'members' => ['CidrIpv6' => ['shape' => 'String', 'locationName' => 'cidrIpv6',],],
        ],
        'Ipv6RangeList' => ['type' => 'list', 'member' => ['shape' => 'Ipv6Range', 'locationName' => 'item',],],
        'KeyNameStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'KeyName',],],
        'KeyPair' => [
            'type' => 'structure',
            'members' => [
                'KeyFingerprint' => ['shape' => 'String', 'locationName' => 'keyFingerprint',],
                'KeyMaterial' => ['shape' => 'String', 'locationName' => 'keyMaterial',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
            ],
        ],
        'KeyPairInfo' => [
            'type' => 'structure',
            'members' => [
                'KeyFingerprint' => ['shape' => 'String', 'locationName' => 'keyFingerprint',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
            ],
        ],
        'KeyPairList' => ['type' => 'list', 'member' => ['shape' => 'KeyPairInfo', 'locationName' => 'item',],],
        'LaunchPermission' => [
            'type' => 'structure',
            'members' => [
                'Group' => ['shape' => 'PermissionGroup', 'locationName' => 'group',],
                'UserId' => ['shape' => 'String', 'locationName' => 'userId',],
            ],
        ],
        'LaunchPermissionList' => [
            'type' => 'list',
            'member' => ['shape' => 'LaunchPermission', 'locationName' => 'item',],
        ],
        'LaunchPermissionModifications' => [
            'type' => 'structure',
            'members' => [
                'Add' => ['shape' => 'LaunchPermissionList',],
                'Remove' => ['shape' => 'LaunchPermissionList',],
            ],
        ],
        'LaunchSpecification' => [
            'type' => 'structure',
            'members' => [
                'UserData' => ['shape' => 'String', 'locationName' => 'userData',],
                'SecurityGroups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'AddressingType' => ['shape' => 'String', 'locationName' => 'addressingType',],
                'BlockDeviceMappings' => ['shape' => 'BlockDeviceMappingList', 'locationName' => 'blockDeviceMapping',],
                'EbsOptimized' => ['shape' => 'Boolean', 'locationName' => 'ebsOptimized',],
                'IamInstanceProfile' => [
                    'shape' => 'IamInstanceProfileSpecification',
                    'locationName' => 'iamInstanceProfile',
                ],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'KernelId' => ['shape' => 'String', 'locationName' => 'kernelId',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
                'NetworkInterfaces' => [
                    'shape' => 'InstanceNetworkInterfaceSpecificationList',
                    'locationName' => 'networkInterfaceSet',
                ],
                'Placement' => ['shape' => 'SpotPlacement', 'locationName' => 'placement',],
                'RamdiskId' => ['shape' => 'String', 'locationName' => 'ramdiskId',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'Monitoring' => ['shape' => 'RunInstancesMonitoringEnabled', 'locationName' => 'monitoring',],
            ],
        ],
        'LaunchSpecsList' => [
            'type' => 'list',
            'member' => ['shape' => 'SpotFleetLaunchSpecification', 'locationName' => 'item',],
            'min' => 1,
        ],
        'ListingState' => ['type' => 'string', 'enum' => ['available', 'sold', 'cancelled', 'pending',],],
        'ListingStatus' => ['type' => 'string', 'enum' => ['active', 'pending', 'cancelled', 'closed',],],
        'Long' => ['type' => 'long',],
        'MaxResults' => ['type' => 'integer', 'max' => 255, 'min' => 5,],
        'ModifyHostsRequest' => [
            'type' => 'structure',
            'required' => ['AutoPlacement', 'HostIds',],
            'members' => [
                'AutoPlacement' => ['shape' => 'AutoPlacement', 'locationName' => 'autoPlacement',],
                'HostIds' => ['shape' => 'RequestHostIdList', 'locationName' => 'hostId',],
            ],
        ],
        'ModifyHostsResult' => [
            'type' => 'structure',
            'members' => [
                'Successful' => ['shape' => 'ResponseHostIdList', 'locationName' => 'successful',],
                'Unsuccessful' => ['shape' => 'UnsuccessfulItemList', 'locationName' => 'unsuccessful',],
            ],
        ],
        'ModifyIdFormatRequest' => [
            'type' => 'structure',
            'required' => ['Resource', 'UseLongIds',],
            'members' => ['Resource' => ['shape' => 'String',], 'UseLongIds' => ['shape' => 'Boolean',],],
        ],
        'ModifyIdentityIdFormatRequest' => [
            'type' => 'structure',
            'required' => ['PrincipalArn', 'Resource', 'UseLongIds',],
            'members' => [
                'PrincipalArn' => ['shape' => 'String', 'locationName' => 'principalArn',],
                'Resource' => ['shape' => 'String', 'locationName' => 'resource',],
                'UseLongIds' => ['shape' => 'Boolean', 'locationName' => 'useLongIds',],
            ],
        ],
        'ModifyImageAttributeRequest' => [
            'type' => 'structure',
            'required' => ['ImageId',],
            'members' => [
                'Attribute' => ['shape' => 'String',],
                'Description' => ['shape' => 'AttributeValue',],
                'ImageId' => ['shape' => 'String',],
                'LaunchPermission' => ['shape' => 'LaunchPermissionModifications',],
                'OperationType' => ['shape' => 'OperationType',],
                'ProductCodes' => ['shape' => 'ProductCodeStringList', 'locationName' => 'ProductCode',],
                'UserGroups' => ['shape' => 'UserGroupStringList', 'locationName' => 'UserGroup',],
                'UserIds' => ['shape' => 'UserIdStringList', 'locationName' => 'UserId',],
                'Value' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ModifyInstanceAttributeRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId',],
            'members' => [
                'SourceDestCheck' => ['shape' => 'AttributeBooleanValue',],
                'Attribute' => ['shape' => 'InstanceAttributeName', 'locationName' => 'attribute',],
                'BlockDeviceMappings' => [
                    'shape' => 'InstanceBlockDeviceMappingSpecificationList',
                    'locationName' => 'blockDeviceMapping',
                ],
                'DisableApiTermination' => [
                    'shape' => 'AttributeBooleanValue',
                    'locationName' => 'disableApiTermination',
                ],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EbsOptimized' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'ebsOptimized',],
                'EnaSupport' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'enaSupport',],
                'Groups' => ['shape' => 'GroupIdStringList', 'locationName' => 'GroupId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceInitiatedShutdownBehavior' => [
                    'shape' => 'AttributeValue',
                    'locationName' => 'instanceInitiatedShutdownBehavior',
                ],
                'InstanceType' => ['shape' => 'AttributeValue', 'locationName' => 'instanceType',],
                'Kernel' => ['shape' => 'AttributeValue', 'locationName' => 'kernel',],
                'Ramdisk' => ['shape' => 'AttributeValue', 'locationName' => 'ramdisk',],
                'SriovNetSupport' => ['shape' => 'AttributeValue', 'locationName' => 'sriovNetSupport',],
                'UserData' => ['shape' => 'BlobAttributeValue', 'locationName' => 'userData',],
                'Value' => ['shape' => 'String', 'locationName' => 'value',],
            ],
        ],
        'ModifyInstancePlacementRequest' => [
            'type' => 'structure',
            'required' => ['InstanceId',],
            'members' => [
                'Affinity' => ['shape' => 'Affinity', 'locationName' => 'affinity',],
                'HostId' => ['shape' => 'String', 'locationName' => 'hostId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'Tenancy' => ['shape' => 'HostTenancy', 'locationName' => 'tenancy',],
            ],
        ],
        'ModifyInstancePlacementResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'ModifyNetworkInterfaceAttributeRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId',],
            'members' => [
                'Attachment' => [
                    'shape' => 'NetworkInterfaceAttachmentChanges',
                    'locationName' => 'attachment',
                ],
                'Description' => ['shape' => 'AttributeValue', 'locationName' => 'description',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Groups' => ['shape' => 'SecurityGroupIdStringList', 'locationName' => 'SecurityGroupId',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'SourceDestCheck' => ['shape' => 'AttributeBooleanValue', 'locationName' => 'sourceDestCheck',],
            ],
        ],
        'ModifyReservedInstancesRequest' => [
            'type' => 'structure',
            'required' => ['ReservedInstancesIds', 'TargetConfigurations',],
            'members' => [
                'ReservedInstancesIds' => [
                    'shape' => 'ReservedInstancesIdStringList',
                    'locationName' => 'ReservedInstancesId',
                ],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'TargetConfigurations' => [
                    'shape' => 'ReservedInstancesConfigurationList',
                    'locationName' => 'ReservedInstancesConfigurationSetItemType',
                ],
            ],
        ],
        'ModifyReservedInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstancesModificationId' => [
                    'shape' => 'String',
                    'locationName' => 'reservedInstancesModificationId',
                ],
            ],
        ],
        'ModifySnapshotAttributeRequest' => [
            'type' => 'structure',
            'required' => ['SnapshotId',],
            'members' => [
                'Attribute' => ['shape' => 'SnapshotAttributeName',],
                'CreateVolumePermission' => ['shape' => 'CreateVolumePermissionModifications',],
                'GroupNames' => ['shape' => 'GroupNameStringList', 'locationName' => 'UserGroup',],
                'OperationType' => ['shape' => 'OperationType',],
                'SnapshotId' => ['shape' => 'String',],
                'UserIds' => ['shape' => 'UserIdStringList', 'locationName' => 'UserId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ModifySpotFleetRequestRequest' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestId',],
            'members' => [
                'ExcessCapacityTerminationPolicy' => [
                    'shape' => 'ExcessCapacityTerminationPolicy',
                    'locationName' => 'excessCapacityTerminationPolicy',
                ],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
                'TargetCapacity' => ['shape' => 'Integer', 'locationName' => 'targetCapacity',],
            ],
        ],
        'ModifySpotFleetRequestResponse' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'ModifySubnetAttributeRequest' => [
            'type' => 'structure',
            'required' => ['SubnetId',],
            'members' => [
                'AssignIpv6AddressOnCreation' => ['shape' => 'AttributeBooleanValue',],
                'MapPublicIpOnLaunch' => ['shape' => 'AttributeBooleanValue',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'ModifyVolumeAttributeRequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'AutoEnableIO' => ['shape' => 'AttributeBooleanValue',],
                'VolumeId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ModifyVolumeRequest' => [
            'type' => 'structure',
            'required' => ['VolumeId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean',],
                'VolumeId' => ['shape' => 'String',],
                'Size' => ['shape' => 'Integer',],
                'VolumeType' => ['shape' => 'VolumeType',],
                'Iops' => ['shape' => 'Integer',],
            ],
        ],
        'ModifyVolumeResult' => [
            'type' => 'structure',
            'members' => [
                'VolumeModification' => [
                    'shape' => 'VolumeModification',
                    'locationName' => 'volumeModification',
                ],
            ],
        ],
        'ModifyVpcAttributeRequest' => [
            'type' => 'structure',
            'required' => ['VpcId',],
            'members' => [
                'EnableDnsHostnames' => ['shape' => 'AttributeBooleanValue',],
                'EnableDnsSupport' => ['shape' => 'AttributeBooleanValue',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'ModifyVpcEndpointRequest' => [
            'type' => 'structure',
            'required' => ['VpcEndpointId',],
            'members' => [
                'AddRouteTableIds' => ['shape' => 'ValueStringList', 'locationName' => 'AddRouteTableId',],
                'DryRun' => ['shape' => 'Boolean',],
                'PolicyDocument' => ['shape' => 'String',],
                'RemoveRouteTableIds' => ['shape' => 'ValueStringList', 'locationName' => 'RemoveRouteTableId',],
                'ResetPolicy' => ['shape' => 'Boolean',],
                'VpcEndpointId' => ['shape' => 'String',],
            ],
        ],
        'ModifyVpcEndpointResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'ModifyVpcPeeringConnectionOptionsRequest' => [
            'type' => 'structure',
            'required' => ['VpcPeeringConnectionId',],
            'members' => [
                'AccepterPeeringConnectionOptions' => ['shape' => 'PeeringConnectionOptionsRequest',],
                'DryRun' => ['shape' => 'Boolean',],
                'RequesterPeeringConnectionOptions' => ['shape' => 'PeeringConnectionOptionsRequest',],
                'VpcPeeringConnectionId' => ['shape' => 'String',],
            ],
        ],
        'ModifyVpcPeeringConnectionOptionsResult' => [
            'type' => 'structure',
            'members' => [
                'AccepterPeeringConnectionOptions' => [
                    'shape' => 'PeeringConnectionOptions',
                    'locationName' => 'accepterPeeringConnectionOptions',
                ],
                'RequesterPeeringConnectionOptions' => [
                    'shape' => 'PeeringConnectionOptions',
                    'locationName' => 'requesterPeeringConnectionOptions',
                ],
            ],
        ],
        'MonitorInstancesRequest' => [
            'type' => 'structure',
            'required' => ['InstanceIds',],
            'members' => [
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'MonitorInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'InstanceMonitorings' => [
                    'shape' => 'InstanceMonitoringList',
                    'locationName' => 'instancesSet',
                ],
            ],
        ],
        'Monitoring' => [
            'type' => 'structure',
            'members' => ['State' => ['shape' => 'MonitoringState', 'locationName' => 'state',],],
        ],
        'MonitoringState' => ['type' => 'string', 'enum' => ['disabled', 'disabling', 'enabled', 'pending',],],
        'MoveAddressToVpcRequest' => [
            'type' => 'structure',
            'required' => ['PublicIp',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
            ],
        ],
        'MoveAddressToVpcResult' => [
            'type' => 'structure',
            'members' => [
                'AllocationId' => ['shape' => 'String', 'locationName' => 'allocationId',],
                'Status' => ['shape' => 'Status', 'locationName' => 'status',],
            ],
        ],
        'MoveStatus' => ['type' => 'string', 'enum' => ['movingToVpc', 'restoringToClassic',],],
        'MovingAddressStatus' => [
            'type' => 'structure',
            'members' => [
                'MoveStatus' => ['shape' => 'MoveStatus', 'locationName' => 'moveStatus',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
            ],
        ],
        'MovingAddressStatusSet' => [
            'type' => 'list',
            'member' => ['shape' => 'MovingAddressStatus', 'locationName' => 'item',],
        ],
        'NatGateway' => [
            'type' => 'structure',
            'members' => [
                'CreateTime' => ['shape' => 'DateTime', 'locationName' => 'createTime',],
                'DeleteTime' => ['shape' => 'DateTime', 'locationName' => 'deleteTime',],
                'FailureCode' => ['shape' => 'String', 'locationName' => 'failureCode',],
                'FailureMessage' => ['shape' => 'String', 'locationName' => 'failureMessage',],
                'NatGatewayAddresses' => [
                    'shape' => 'NatGatewayAddressList',
                    'locationName' => 'natGatewayAddressSet',
                ],
                'NatGatewayId' => ['shape' => 'String', 'locationName' => 'natGatewayId',],
                'ProvisionedBandwidth' => [
                    'shape' => 'ProvisionedBandwidth',
                    'locationName' => 'provisionedBandwidth',
                ],
                'State' => ['shape' => 'NatGatewayState', 'locationName' => 'state',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'NatGatewayAddress' => [
            'type' => 'structure',
            'members' => [
                'AllocationId' => ['shape' => 'String', 'locationName' => 'allocationId',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'PrivateIp' => ['shape' => 'String', 'locationName' => 'privateIp',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
            ],
        ],
        'NatGatewayAddressList' => [
            'type' => 'list',
            'member' => ['shape' => 'NatGatewayAddress', 'locationName' => 'item',],
        ],
        'NatGatewayList' => ['type' => 'list', 'member' => ['shape' => 'NatGateway', 'locationName' => 'item',],],
        'NatGatewayState' => [
            'type' => 'string',
            'enum' => ['pending', 'failed', 'available', 'deleting', 'deleted',],
        ],
        'NetworkAcl' => [
            'type' => 'structure',
            'members' => [
                'Associations' => [
                    'shape' => 'NetworkAclAssociationList',
                    'locationName' => 'associationSet',
                ],
                'Entries' => ['shape' => 'NetworkAclEntryList', 'locationName' => 'entrySet',],
                'IsDefault' => ['shape' => 'Boolean', 'locationName' => 'default',],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'NetworkAclAssociation' => [
            'type' => 'structure',
            'members' => [
                'NetworkAclAssociationId' => [
                    'shape' => 'String',
                    'locationName' => 'networkAclAssociationId',
                ],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'NetworkAclAssociationList' => [
            'type' => 'list',
            'member' => ['shape' => 'NetworkAclAssociation', 'locationName' => 'item',],
        ],
        'NetworkAclEntry' => [
            'type' => 'structure',
            'members' => [
                'CidrBlock' => ['shape' => 'String', 'locationName' => 'cidrBlock',],
                'Egress' => ['shape' => 'Boolean', 'locationName' => 'egress',],
                'IcmpTypeCode' => ['shape' => 'IcmpTypeCode', 'locationName' => 'icmpTypeCode',],
                'Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],
                'PortRange' => ['shape' => 'PortRange', 'locationName' => 'portRange',],
                'Protocol' => ['shape' => 'String', 'locationName' => 'protocol',],
                'RuleAction' => ['shape' => 'RuleAction', 'locationName' => 'ruleAction',],
                'RuleNumber' => ['shape' => 'Integer', 'locationName' => 'ruleNumber',],
            ],
        ],
        'NetworkAclEntryList' => [
            'type' => 'list',
            'member' => ['shape' => 'NetworkAclEntry', 'locationName' => 'item',],
        ],
        'NetworkAclList' => ['type' => 'list', 'member' => ['shape' => 'NetworkAcl', 'locationName' => 'item',],],
        'NetworkInterface' => [
            'type' => 'structure',
            'members' => [
                'Association' => ['shape' => 'NetworkInterfaceAssociation', 'locationName' => 'association',],
                'Attachment' => ['shape' => 'NetworkInterfaceAttachment', 'locationName' => 'attachment',],
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Groups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'InterfaceType' => ['shape' => 'NetworkInterfaceType', 'locationName' => 'interfaceType',],
                'Ipv6Addresses' => [
                    'shape' => 'NetworkInterfaceIpv6AddressesList',
                    'locationName' => 'ipv6AddressesSet',
                ],
                'MacAddress' => ['shape' => 'String', 'locationName' => 'macAddress',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'PrivateDnsName' => ['shape' => 'String', 'locationName' => 'privateDnsName',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'PrivateIpAddresses' => [
                    'shape' => 'NetworkInterfacePrivateIpAddressList',
                    'locationName' => 'privateIpAddressesSet',
                ],
                'RequesterId' => ['shape' => 'String', 'locationName' => 'requesterId',],
                'RequesterManaged' => ['shape' => 'Boolean', 'locationName' => 'requesterManaged',],
                'SourceDestCheck' => ['shape' => 'Boolean', 'locationName' => 'sourceDestCheck',],
                'Status' => ['shape' => 'NetworkInterfaceStatus', 'locationName' => 'status',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'TagSet' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'NetworkInterfaceAssociation' => [
            'type' => 'structure',
            'members' => [
                'AllocationId' => ['shape' => 'String', 'locationName' => 'allocationId',],
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'IpOwnerId' => ['shape' => 'String', 'locationName' => 'ipOwnerId',],
                'PublicDnsName' => ['shape' => 'String', 'locationName' => 'publicDnsName',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
            ],
        ],
        'NetworkInterfaceAttachment' => [
            'type' => 'structure',
            'members' => [
                'AttachTime' => ['shape' => 'DateTime', 'locationName' => 'attachTime',],
                'AttachmentId' => ['shape' => 'String', 'locationName' => 'attachmentId',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
                'DeviceIndex' => ['shape' => 'Integer', 'locationName' => 'deviceIndex',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceOwnerId' => ['shape' => 'String', 'locationName' => 'instanceOwnerId',],
                'Status' => ['shape' => 'AttachmentStatus', 'locationName' => 'status',],
            ],
        ],
        'NetworkInterfaceAttachmentChanges' => [
            'type' => 'structure',
            'members' => [
                'AttachmentId' => ['shape' => 'String', 'locationName' => 'attachmentId',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
            ],
        ],
        'NetworkInterfaceAttribute' => [
            'type' => 'string',
            'enum' => ['description', 'groupSet', 'sourceDestCheck', 'attachment',],
        ],
        'NetworkInterfaceIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'NetworkInterfaceIpv6Address' => [
            'type' => 'structure',
            'members' => ['Ipv6Address' => ['shape' => 'String', 'locationName' => 'ipv6Address',],],
        ],
        'NetworkInterfaceIpv6AddressesList' => [
            'type' => 'list',
            'member' => ['shape' => 'NetworkInterfaceIpv6Address', 'locationName' => 'item',],
        ],
        'NetworkInterfaceList' => [
            'type' => 'list',
            'member' => ['shape' => 'NetworkInterface', 'locationName' => 'item',],
        ],
        'NetworkInterfacePrivateIpAddress' => [
            'type' => 'structure',
            'members' => [
                'Association' => ['shape' => 'NetworkInterfaceAssociation', 'locationName' => 'association',],
                'Primary' => ['shape' => 'Boolean', 'locationName' => 'primary',],
                'PrivateDnsName' => ['shape' => 'String', 'locationName' => 'privateDnsName',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
            ],
        ],
        'NetworkInterfacePrivateIpAddressList' => [
            'type' => 'list',
            'member' => ['shape' => 'NetworkInterfacePrivateIpAddress', 'locationName' => 'item',],
        ],
        'NetworkInterfaceStatus' => ['type' => 'string', 'enum' => ['available', 'attaching', 'in-use', 'detaching',],],
        'NetworkInterfaceType' => ['type' => 'string', 'enum' => ['interface', 'natGateway',],],
        'NewDhcpConfiguration' => [
            'type' => 'structure',
            'members' => [
                'Key' => ['shape' => 'String', 'locationName' => 'key',],
                'Values' => ['shape' => 'ValueStringList', 'locationName' => 'Value',],
            ],
        ],
        'NewDhcpConfigurationList' => [
            'type' => 'list',
            'member' => ['shape' => 'NewDhcpConfiguration', 'locationName' => 'item',],
        ],
        'NextToken' => ['type' => 'string', 'max' => 1024, 'min' => 1,],
        'OccurrenceDayRequestSet' => [
            'type' => 'list',
            'member' => ['shape' => 'Integer', 'locationName' => 'OccurenceDay',],
        ],
        'OccurrenceDaySet' => ['type' => 'list', 'member' => ['shape' => 'Integer', 'locationName' => 'item',],],
        'OfferingClassType' => ['type' => 'string', 'enum' => ['standard', 'convertible',],],
        'OfferingTypeValues' => [
            'type' => 'string',
            'enum' => [
                'Heavy Utilization',
                'Medium Utilization',
                'Light Utilization',
                'No Upfront',
                'Partial Upfront',
                'All Upfront',
            ],
        ],
        'OperationType' => ['type' => 'string', 'enum' => ['add', 'remove',],],
        'OwnerStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'Owner',],],
        'PaymentOption' => ['type' => 'string', 'enum' => ['AllUpfront', 'PartialUpfront', 'NoUpfront',],],
        'PciId' => [
            'type' => 'structure',
            'members' => [
                'DeviceId' => ['shape' => 'String',],
                'VendorId' => ['shape' => 'String',],
                'SubsystemId' => ['shape' => 'String',],
                'SubsystemVendorId' => ['shape' => 'String',],
            ],
        ],
        'PeeringConnectionOptions' => [
            'type' => 'structure',
            'members' => [
                'AllowDnsResolutionFromRemoteVpc' => [
                    'shape' => 'Boolean',
                    'locationName' => 'allowDnsResolutionFromRemoteVpc',
                ],
                'AllowEgressFromLocalClassicLinkToRemoteVpc' => [
                    'shape' => 'Boolean',
                    'locationName' => 'allowEgressFromLocalClassicLinkToRemoteVpc',
                ],
                'AllowEgressFromLocalVpcToRemoteClassicLink' => [
                    'shape' => 'Boolean',
                    'locationName' => 'allowEgressFromLocalVpcToRemoteClassicLink',
                ],
            ],
        ],
        'PeeringConnectionOptionsRequest' => [
            'type' => 'structure',
            'members' => [
                'AllowDnsResolutionFromRemoteVpc' => ['shape' => 'Boolean',],
                'AllowEgressFromLocalClassicLinkToRemoteVpc' => ['shape' => 'Boolean',],
                'AllowEgressFromLocalVpcToRemoteClassicLink' => ['shape' => 'Boolean',],
            ],
        ],
        'PermissionGroup' => ['type' => 'string', 'enum' => ['all',],],
        'Placement' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Affinity' => ['shape' => 'String', 'locationName' => 'affinity',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'HostId' => ['shape' => 'String', 'locationName' => 'hostId',],
                'Tenancy' => ['shape' => 'Tenancy', 'locationName' => 'tenancy',],
                'SpreadDomain' => ['shape' => 'String', 'locationName' => 'spreadDomain',],
            ],
        ],
        'PlacementGroup' => [
            'type' => 'structure',
            'members' => [
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'State' => ['shape' => 'PlacementGroupState', 'locationName' => 'state',],
                'Strategy' => ['shape' => 'PlacementStrategy', 'locationName' => 'strategy',],
            ],
        ],
        'PlacementGroupList' => [
            'type' => 'list',
            'member' => ['shape' => 'PlacementGroup', 'locationName' => 'item',],
        ],
        'PlacementGroupState' => ['type' => 'string', 'enum' => ['pending', 'available', 'deleting', 'deleted',],],
        'PlacementGroupStringList' => ['type' => 'list', 'member' => ['shape' => 'String',],],
        'PlacementStrategy' => ['type' => 'string', 'enum' => ['cluster',],],
        'PlatformValues' => ['type' => 'string', 'enum' => ['Windows',],],
        'PortRange' => [
            'type' => 'structure',
            'members' => [
                'From' => ['shape' => 'Integer', 'locationName' => 'from',],
                'To' => ['shape' => 'Integer', 'locationName' => 'to',],
            ],
        ],
        'PrefixList' => [
            'type' => 'structure',
            'members' => [
                'Cidrs' => ['shape' => 'ValueStringList', 'locationName' => 'cidrSet',],
                'PrefixListId' => ['shape' => 'String', 'locationName' => 'prefixListId',],
                'PrefixListName' => ['shape' => 'String', 'locationName' => 'prefixListName',],
            ],
        ],
        'PrefixListId' => [
            'type' => 'structure',
            'members' => ['PrefixListId' => ['shape' => 'String', 'locationName' => 'prefixListId',],],
        ],
        'PrefixListIdList' => ['type' => 'list', 'member' => ['shape' => 'PrefixListId', 'locationName' => 'item',],],
        'PrefixListIdSet' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'PrefixListSet' => ['type' => 'list', 'member' => ['shape' => 'PrefixList', 'locationName' => 'item',],],
        'PriceSchedule' => [
            'type' => 'structure',
            'members' => [
                'Active' => ['shape' => 'Boolean', 'locationName' => 'active',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Price' => ['shape' => 'Double', 'locationName' => 'price',],
                'Term' => ['shape' => 'Long', 'locationName' => 'term',],
            ],
        ],
        'PriceScheduleList' => ['type' => 'list', 'member' => ['shape' => 'PriceSchedule', 'locationName' => 'item',],],
        'PriceScheduleSpecification' => [
            'type' => 'structure',
            'members' => [
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Price' => ['shape' => 'Double', 'locationName' => 'price',],
                'Term' => ['shape' => 'Long', 'locationName' => 'term',],
            ],
        ],
        'PriceScheduleSpecificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'PriceScheduleSpecification', 'locationName' => 'item',],
        ],
        'PricingDetail' => [
            'type' => 'structure',
            'members' => [
                'Count' => ['shape' => 'Integer', 'locationName' => 'count',],
                'Price' => ['shape' => 'Double', 'locationName' => 'price',],
            ],
        ],
        'PricingDetailsList' => [
            'type' => 'list',
            'member' => ['shape' => 'PricingDetail', 'locationName' => 'item',],
        ],
        'PrivateIpAddressConfigSet' => [
            'type' => 'list',
            'member' => [
                'shape' => 'ScheduledInstancesPrivateIpAddressConfig',
                'locationName' => 'PrivateIpAddressConfigSet',
            ],
        ],
        'PrivateIpAddressSpecification' => [
            'type' => 'structure',
            'required' => ['PrivateIpAddress',],
            'members' => [
                'Primary' => ['shape' => 'Boolean', 'locationName' => 'primary',],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
            ],
        ],
        'PrivateIpAddressSpecificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'PrivateIpAddressSpecification', 'locationName' => 'item',],
        ],
        'PrivateIpAddressStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'PrivateIpAddress',],
        ],
        'ProductCode' => [
            'type' => 'structure',
            'members' => [
                'ProductCodeId' => ['shape' => 'String', 'locationName' => 'productCode',],
                'ProductCodeType' => ['shape' => 'ProductCodeValues', 'locationName' => 'type',],
            ],
        ],
        'ProductCodeList' => ['type' => 'list', 'member' => ['shape' => 'ProductCode', 'locationName' => 'item',],],
        'ProductCodeStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ProductCode',],
        ],
        'ProductCodeValues' => ['type' => 'string', 'enum' => ['devpay', 'marketplace',],],
        'ProductDescriptionList' => ['type' => 'list', 'member' => ['shape' => 'String',],],
        'PropagatingVgw' => [
            'type' => 'structure',
            'members' => ['GatewayId' => ['shape' => 'String', 'locationName' => 'gatewayId',],],
        ],
        'PropagatingVgwList' => [
            'type' => 'list',
            'member' => ['shape' => 'PropagatingVgw', 'locationName' => 'item',],
        ],
        'ProvisionedBandwidth' => [
            'type' => 'structure',
            'members' => [
                'ProvisionTime' => ['shape' => 'DateTime', 'locationName' => 'provisionTime',],
                'Provisioned' => ['shape' => 'String', 'locationName' => 'provisioned',],
                'RequestTime' => ['shape' => 'DateTime', 'locationName' => 'requestTime',],
                'Requested' => ['shape' => 'String', 'locationName' => 'requested',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
            ],
        ],
        'PublicIpStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'PublicIp',],],
        'Purchase' => [
            'type' => 'structure',
            'members' => [
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Duration' => ['shape' => 'Integer', 'locationName' => 'duration',],
                'HostIdSet' => ['shape' => 'ResponseHostIdSet', 'locationName' => 'hostIdSet',],
                'HostReservationId' => ['shape' => 'String', 'locationName' => 'hostReservationId',],
                'HourlyPrice' => ['shape' => 'String', 'locationName' => 'hourlyPrice',],
                'InstanceFamily' => ['shape' => 'String', 'locationName' => 'instanceFamily',],
                'PaymentOption' => ['shape' => 'PaymentOption', 'locationName' => 'paymentOption',],
                'UpfrontPrice' => ['shape' => 'String', 'locationName' => 'upfrontPrice',],
            ],
        ],
        'PurchaseHostReservationRequest' => [
            'type' => 'structure',
            'required' => ['HostIdSet', 'OfferingId',],
            'members' => [
                'ClientToken' => ['shape' => 'String',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues',],
                'HostIdSet' => ['shape' => 'RequestHostIdSet',],
                'LimitPrice' => ['shape' => 'String',],
                'OfferingId' => ['shape' => 'String',],
            ],
        ],
        'PurchaseHostReservationResult' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'Purchase' => ['shape' => 'PurchaseSet', 'locationName' => 'purchase',],
                'TotalHourlyPrice' => ['shape' => 'String', 'locationName' => 'totalHourlyPrice',],
                'TotalUpfrontPrice' => ['shape' => 'String', 'locationName' => 'totalUpfrontPrice',],
            ],
        ],
        'PurchaseRequest' => [
            'type' => 'structure',
            'required' => ['InstanceCount', 'PurchaseToken',],
            'members' => ['InstanceCount' => ['shape' => 'Integer',], 'PurchaseToken' => ['shape' => 'String',],],
        ],
        'PurchaseRequestSet' => [
            'type' => 'list',
            'member' => ['shape' => 'PurchaseRequest', 'locationName' => 'PurchaseRequest',],
            'min' => 1,
        ],
        'PurchaseReservedInstancesOfferingRequest' => [
            'type' => 'structure',
            'required' => ['InstanceCount', 'ReservedInstancesOfferingId',],
            'members' => [
                'InstanceCount' => ['shape' => 'Integer',],
                'ReservedInstancesOfferingId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'LimitPrice' => ['shape' => 'ReservedInstanceLimitPrice', 'locationName' => 'limitPrice',],
            ],
        ],
        'PurchaseReservedInstancesOfferingResult' => [
            'type' => 'structure',
            'members' => ['ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],],
        ],
        'PurchaseScheduledInstancesRequest' => [
            'type' => 'structure',
            'required' => ['PurchaseRequests',],
            'members' => [
                'ClientToken' => ['shape' => 'String', 'idempotencyToken' => true,],
                'DryRun' => ['shape' => 'Boolean',],
                'PurchaseRequests' => ['shape' => 'PurchaseRequestSet', 'locationName' => 'PurchaseRequest',],
            ],
        ],
        'PurchaseScheduledInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'ScheduledInstanceSet' => [
                    'shape' => 'PurchasedScheduledInstanceSet',
                    'locationName' => 'scheduledInstanceSet',
                ],
            ],
        ],
        'PurchaseSet' => ['type' => 'list', 'member' => ['shape' => 'Purchase',],],
        'PurchasedScheduledInstanceSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ScheduledInstance', 'locationName' => 'item',],
        ],
        'RIProductDescription' => [
            'type' => 'string',
            'enum' => ['Linux/UNIX', 'Linux/UNIX (Amazon VPC)', 'Windows', 'Windows (Amazon VPC)',],
        ],
        'ReasonCodesList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReportInstanceReasonCodes', 'locationName' => 'item',],
        ],
        'RebootInstancesRequest' => [
            'type' => 'structure',
            'required' => ['InstanceIds',],
            'members' => [
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'RecurringCharge' => [
            'type' => 'structure',
            'members' => [
                'Amount' => ['shape' => 'Double', 'locationName' => 'amount',],
                'Frequency' => ['shape' => 'RecurringChargeFrequency', 'locationName' => 'frequency',],
            ],
        ],
        'RecurringChargeFrequency' => ['type' => 'string', 'enum' => ['Hourly',],],
        'RecurringChargesList' => [
            'type' => 'list',
            'member' => ['shape' => 'RecurringCharge', 'locationName' => 'item',],
        ],
        'Region' => [
            'type' => 'structure',
            'members' => [
                'Endpoint' => ['shape' => 'String', 'locationName' => 'regionEndpoint',],
                'RegionName' => ['shape' => 'String', 'locationName' => 'regionName',],
            ],
        ],
        'RegionList' => ['type' => 'list', 'member' => ['shape' => 'Region', 'locationName' => 'item',],],
        'RegionNameStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'RegionName',],
        ],
        'RegisterImageRequest' => [
            'type' => 'structure',
            'required' => ['Name',],
            'members' => [
                'ImageLocation' => ['shape' => 'String',],
                'Architecture' => ['shape' => 'ArchitectureValues', 'locationName' => 'architecture',],
                'BlockDeviceMappings' => [
                    'shape' => 'BlockDeviceMappingRequestList',
                    'locationName' => 'BlockDeviceMapping',
                ],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EnaSupport' => ['shape' => 'Boolean', 'locationName' => 'enaSupport',],
                'KernelId' => ['shape' => 'String', 'locationName' => 'kernelId',],
                'Name' => ['shape' => 'String', 'locationName' => 'name',],
                'BillingProducts' => ['shape' => 'BillingProductList', 'locationName' => 'BillingProduct',],
                'RamdiskId' => ['shape' => 'String', 'locationName' => 'ramdiskId',],
                'RootDeviceName' => ['shape' => 'String', 'locationName' => 'rootDeviceName',],
                'SriovNetSupport' => ['shape' => 'String', 'locationName' => 'sriovNetSupport',],
                'VirtualizationType' => ['shape' => 'String', 'locationName' => 'virtualizationType',],
            ],
        ],
        'RegisterImageResult' => [
            'type' => 'structure',
            'members' => ['ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],],
        ],
        'RejectVpcPeeringConnectionRequest' => [
            'type' => 'structure',
            'required' => ['VpcPeeringConnectionId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'RejectVpcPeeringConnectionResult' => [
            'type' => 'structure',
            'members' => ['Return' => ['shape' => 'Boolean', 'locationName' => 'return',],],
        ],
        'ReleaseAddressRequest' => [
            'type' => 'structure',
            'members' => [
                'AllocationId' => ['shape' => 'String',],
                'PublicIp' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ReleaseHostsRequest' => [
            'type' => 'structure',
            'required' => ['HostIds',],
            'members' => ['HostIds' => ['shape' => 'RequestHostIdList', 'locationName' => 'hostId',],],
        ],
        'ReleaseHostsResult' => [
            'type' => 'structure',
            'members' => [
                'Successful' => ['shape' => 'ResponseHostIdList', 'locationName' => 'successful',],
                'Unsuccessful' => ['shape' => 'UnsuccessfulItemList', 'locationName' => 'unsuccessful',],
            ],
        ],
        'ReplaceIamInstanceProfileAssociationRequest' => [
            'type' => 'structure',
            'required' => ['IamInstanceProfile', 'AssociationId',],
            'members' => [
                'IamInstanceProfile' => ['shape' => 'IamInstanceProfileSpecification',],
                'AssociationId' => ['shape' => 'String',],
            ],
        ],
        'ReplaceIamInstanceProfileAssociationResult' => [
            'type' => 'structure',
            'members' => [
                'IamInstanceProfileAssociation' => [
                    'shape' => 'IamInstanceProfileAssociation',
                    'locationName' => 'iamInstanceProfileAssociation',
                ],
            ],
        ],
        'ReplaceNetworkAclAssociationRequest' => [
            'type' => 'structure',
            'required' => ['AssociationId', 'NetworkAclId',],
            'members' => [
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
            ],
        ],
        'ReplaceNetworkAclAssociationResult' => [
            'type' => 'structure',
            'members' => ['NewAssociationId' => ['shape' => 'String', 'locationName' => 'newAssociationId',],],
        ],
        'ReplaceNetworkAclEntryRequest' => [
            'type' => 'structure',
            'required' => ['Egress', 'NetworkAclId', 'Protocol', 'RuleAction', 'RuleNumber',],
            'members' => [
                'CidrBlock' => ['shape' => 'String', 'locationName' => 'cidrBlock',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Egress' => ['shape' => 'Boolean', 'locationName' => 'egress',],
                'IcmpTypeCode' => ['shape' => 'IcmpTypeCode', 'locationName' => 'Icmp',],
                'Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],
                'NetworkAclId' => ['shape' => 'String', 'locationName' => 'networkAclId',],
                'PortRange' => ['shape' => 'PortRange', 'locationName' => 'portRange',],
                'Protocol' => ['shape' => 'String', 'locationName' => 'protocol',],
                'RuleAction' => ['shape' => 'RuleAction', 'locationName' => 'ruleAction',],
                'RuleNumber' => ['shape' => 'Integer', 'locationName' => 'ruleNumber',],
            ],
        ],
        'ReplaceRouteRequest' => [
            'type' => 'structure',
            'required' => ['RouteTableId',],
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String', 'locationName' => 'destinationCidrBlock',],
                'DestinationIpv6CidrBlock' => ['shape' => 'String', 'locationName' => 'destinationIpv6CidrBlock',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EgressOnlyInternetGatewayId' => [
                    'shape' => 'String',
                    'locationName' => 'egressOnlyInternetGatewayId',
                ],
                'GatewayId' => ['shape' => 'String', 'locationName' => 'gatewayId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'NatGatewayId' => ['shape' => 'String', 'locationName' => 'natGatewayId',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'ReplaceRouteTableAssociationRequest' => [
            'type' => 'structure',
            'required' => ['AssociationId', 'RouteTableId',],
            'members' => [
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
            ],
        ],
        'ReplaceRouteTableAssociationResult' => [
            'type' => 'structure',
            'members' => ['NewAssociationId' => ['shape' => 'String', 'locationName' => 'newAssociationId',],],
        ],
        'ReportInstanceReasonCodes' => [
            'type' => 'string',
            'enum' => [
                'instance-stuck-in-state',
                'unresponsive',
                'not-accepting-credentials',
                'password-not-available',
                'performance-network',
                'performance-instance-store',
                'performance-ebs-volume',
                'performance-other',
                'other',
            ],
        ],
        'ReportInstanceStatusRequest' => [
            'type' => 'structure',
            'required' => ['Instances', 'ReasonCodes', 'Status',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EndTime' => ['shape' => 'DateTime', 'locationName' => 'endTime',],
                'Instances' => ['shape' => 'InstanceIdStringList', 'locationName' => 'instanceId',],
                'ReasonCodes' => ['shape' => 'ReasonCodesList', 'locationName' => 'reasonCode',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
                'Status' => ['shape' => 'ReportStatusType', 'locationName' => 'status',],
            ],
        ],
        'ReportStatusType' => ['type' => 'string', 'enum' => ['ok', 'impaired',],],
        'RequestHostIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'RequestHostIdSet' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'RequestSpotFleetRequest' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestConfig',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'SpotFleetRequestConfig' => [
                    'shape' => 'SpotFleetRequestConfigData',
                    'locationName' => 'spotFleetRequestConfig',
                ],
            ],
        ],
        'RequestSpotFleetResponse' => [
            'type' => 'structure',
            'required' => ['SpotFleetRequestId',],
            'members' => ['SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],],
        ],
        'RequestSpotInstancesRequest' => [
            'type' => 'structure',
            'required' => ['SpotPrice',],
            'members' => [
                'AvailabilityZoneGroup' => ['shape' => 'String', 'locationName' => 'availabilityZoneGroup',],
                'BlockDurationMinutes' => ['shape' => 'Integer', 'locationName' => 'blockDurationMinutes',],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'LaunchGroup' => ['shape' => 'String', 'locationName' => 'launchGroup',],
                'LaunchSpecification' => ['shape' => 'RequestSpotLaunchSpecification',],
                'SpotPrice' => ['shape' => 'String', 'locationName' => 'spotPrice',],
                'Type' => ['shape' => 'SpotInstanceType', 'locationName' => 'type',],
                'ValidFrom' => ['shape' => 'DateTime', 'locationName' => 'validFrom',],
                'ValidUntil' => ['shape' => 'DateTime', 'locationName' => 'validUntil',],
            ],
        ],
        'RequestSpotInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'SpotInstanceRequests' => [
                    'shape' => 'SpotInstanceRequestList',
                    'locationName' => 'spotInstanceRequestSet',
                ],
            ],
        ],
        'RequestSpotLaunchSpecification' => [
            'type' => 'structure',
            'members' => [
                'SecurityGroupIds' => ['shape' => 'ValueStringList', 'locationName' => 'SecurityGroupId',],
                'SecurityGroups' => ['shape' => 'ValueStringList', 'locationName' => 'SecurityGroup',],
                'AddressingType' => ['shape' => 'String', 'locationName' => 'addressingType',],
                'BlockDeviceMappings' => ['shape' => 'BlockDeviceMappingList', 'locationName' => 'blockDeviceMapping',],
                'EbsOptimized' => ['shape' => 'Boolean', 'locationName' => 'ebsOptimized',],
                'IamInstanceProfile' => [
                    'shape' => 'IamInstanceProfileSpecification',
                    'locationName' => 'iamInstanceProfile',
                ],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'KernelId' => ['shape' => 'String', 'locationName' => 'kernelId',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
                'Monitoring' => ['shape' => 'RunInstancesMonitoringEnabled', 'locationName' => 'monitoring',],
                'NetworkInterfaces' => [
                    'shape' => 'InstanceNetworkInterfaceSpecificationList',
                    'locationName' => 'NetworkInterface',
                ],
                'Placement' => ['shape' => 'SpotPlacement', 'locationName' => 'placement',],
                'RamdiskId' => ['shape' => 'String', 'locationName' => 'ramdiskId',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'UserData' => ['shape' => 'String', 'locationName' => 'userData',],
            ],
        ],
        'Reservation' => [
            'type' => 'structure',
            'members' => [
                'Groups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'Instances' => ['shape' => 'InstanceList', 'locationName' => 'instancesSet',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'RequesterId' => ['shape' => 'String', 'locationName' => 'requesterId',],
                'ReservationId' => ['shape' => 'String', 'locationName' => 'reservationId',],
            ],
        ],
        'ReservationList' => ['type' => 'list', 'member' => ['shape' => 'Reservation', 'locationName' => 'item',],],
        'ReservationState' => [
            'type' => 'string',
            'enum' => ['payment-pending', 'payment-failed', 'active', 'retired',],
        ],
        'ReservationValue' => [
            'type' => 'structure',
            'members' => [
                'HourlyPrice' => ['shape' => 'String', 'locationName' => 'hourlyPrice',],
                'RemainingTotalValue' => ['shape' => 'String', 'locationName' => 'remainingTotalValue',],
                'RemainingUpfrontValue' => ['shape' => 'String', 'locationName' => 'remainingUpfrontValue',],
            ],
        ],
        'ReservedInstanceIdSet' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ReservedInstanceId',],
        ],
        'ReservedInstanceLimitPrice' => [
            'type' => 'structure',
            'members' => [
                'Amount' => ['shape' => 'Double', 'locationName' => 'amount',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
            ],
        ],
        'ReservedInstanceReservationValue' => [
            'type' => 'structure',
            'members' => [
                'ReservationValue' => ['shape' => 'ReservationValue', 'locationName' => 'reservationValue',],
                'ReservedInstanceId' => ['shape' => 'String', 'locationName' => 'reservedInstanceId',],
            ],
        ],
        'ReservedInstanceReservationValueSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstanceReservationValue', 'locationName' => 'item',],
        ],
        'ReservedInstanceState' => [
            'type' => 'string',
            'enum' => ['payment-pending', 'active', 'payment-failed', 'retired',],
        ],
        'ReservedInstances' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Duration' => ['shape' => 'Long', 'locationName' => 'duration',],
                'End' => ['shape' => 'DateTime', 'locationName' => 'end',],
                'FixedPrice' => ['shape' => 'Float', 'locationName' => 'fixedPrice',],
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'ProductDescription' => ['shape' => 'RIProductDescription', 'locationName' => 'productDescription',],
                'ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],
                'Start' => ['shape' => 'DateTime', 'locationName' => 'start',],
                'State' => ['shape' => 'ReservedInstanceState', 'locationName' => 'state',],
                'UsagePrice' => ['shape' => 'Float', 'locationName' => 'usagePrice',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'InstanceTenancy' => ['shape' => 'Tenancy', 'locationName' => 'instanceTenancy',],
                'OfferingClass' => ['shape' => 'OfferingClassType', 'locationName' => 'offeringClass',],
                'OfferingType' => ['shape' => 'OfferingTypeValues', 'locationName' => 'offeringType',],
                'RecurringCharges' => ['shape' => 'RecurringChargesList', 'locationName' => 'recurringCharges',],
                'Scope' => ['shape' => 'scope', 'locationName' => 'scope',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'ReservedInstancesConfiguration' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'Platform' => ['shape' => 'String', 'locationName' => 'platform',],
                'Scope' => ['shape' => 'scope', 'locationName' => 'scope',],
            ],
        ],
        'ReservedInstancesConfigurationList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstancesConfiguration', 'locationName' => 'item',],
        ],
        'ReservedInstancesId' => [
            'type' => 'structure',
            'members' => ['ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],],
        ],
        'ReservedInstancesIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ReservedInstancesId',],
        ],
        'ReservedInstancesList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstances', 'locationName' => 'item',],
        ],
        'ReservedInstancesListing' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'CreateDate' => ['shape' => 'DateTime', 'locationName' => 'createDate',],
                'InstanceCounts' => ['shape' => 'InstanceCountList', 'locationName' => 'instanceCounts',],
                'PriceSchedules' => ['shape' => 'PriceScheduleList', 'locationName' => 'priceSchedules',],
                'ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],
                'ReservedInstancesListingId' => ['shape' => 'String', 'locationName' => 'reservedInstancesListingId',],
                'Status' => ['shape' => 'ListingStatus', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'UpdateDate' => ['shape' => 'DateTime', 'locationName' => 'updateDate',],
            ],
        ],
        'ReservedInstancesListingList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstancesListing', 'locationName' => 'item',],
        ],
        'ReservedInstancesModification' => [
            'type' => 'structure',
            'members' => [
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'CreateDate' => ['shape' => 'DateTime', 'locationName' => 'createDate',],
                'EffectiveDate' => ['shape' => 'DateTime', 'locationName' => 'effectiveDate',],
                'ModificationResults' => [
                    'shape' => 'ReservedInstancesModificationResultList',
                    'locationName' => 'modificationResultSet',
                ],
                'ReservedInstancesIds' => ['shape' => 'ReservedIntancesIds', 'locationName' => 'reservedInstancesSet',],
                'ReservedInstancesModificationId' => [
                    'shape' => 'String',
                    'locationName' => 'reservedInstancesModificationId',
                ],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'UpdateDate' => ['shape' => 'DateTime', 'locationName' => 'updateDate',],
            ],
        ],
        'ReservedInstancesModificationIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ReservedInstancesModificationId',],
        ],
        'ReservedInstancesModificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstancesModification', 'locationName' => 'item',],
        ],
        'ReservedInstancesModificationResult' => [
            'type' => 'structure',
            'members' => [
                'ReservedInstancesId' => ['shape' => 'String', 'locationName' => 'reservedInstancesId',],
                'TargetConfiguration' => [
                    'shape' => 'ReservedInstancesConfiguration',
                    'locationName' => 'targetConfiguration',
                ],
            ],
        ],
        'ReservedInstancesModificationResultList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstancesModificationResult', 'locationName' => 'item',],
        ],
        'ReservedInstancesOffering' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Duration' => ['shape' => 'Long', 'locationName' => 'duration',],
                'FixedPrice' => ['shape' => 'Float', 'locationName' => 'fixedPrice',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'ProductDescription' => ['shape' => 'RIProductDescription', 'locationName' => 'productDescription',],
                'ReservedInstancesOfferingId' => [
                    'shape' => 'String',
                    'locationName' => 'reservedInstancesOfferingId',
                ],
                'UsagePrice' => ['shape' => 'Float', 'locationName' => 'usagePrice',],
                'CurrencyCode' => ['shape' => 'CurrencyCodeValues', 'locationName' => 'currencyCode',],
                'InstanceTenancy' => ['shape' => 'Tenancy', 'locationName' => 'instanceTenancy',],
                'Marketplace' => ['shape' => 'Boolean', 'locationName' => 'marketplace',],
                'OfferingClass' => ['shape' => 'OfferingClassType', 'locationName' => 'offeringClass',],
                'OfferingType' => ['shape' => 'OfferingTypeValues', 'locationName' => 'offeringType',],
                'PricingDetails' => ['shape' => 'PricingDetailsList', 'locationName' => 'pricingDetailsSet',],
                'RecurringCharges' => ['shape' => 'RecurringChargesList', 'locationName' => 'recurringCharges',],
                'Scope' => ['shape' => 'scope', 'locationName' => 'scope',],
            ],
        ],
        'ReservedInstancesOfferingIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String',],],
        'ReservedInstancesOfferingList' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstancesOffering', 'locationName' => 'item',],
        ],
        'ReservedIntancesIds' => [
            'type' => 'list',
            'member' => ['shape' => 'ReservedInstancesId', 'locationName' => 'item',],
        ],
        'ResetImageAttributeName' => ['type' => 'string', 'enum' => ['launchPermission',],],
        'ResetImageAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'ImageId',],
            'members' => [
                'Attribute' => ['shape' => 'ResetImageAttributeName',],
                'ImageId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ResetInstanceAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'InstanceId',],
            'members' => [
                'Attribute' => ['shape' => 'InstanceAttributeName', 'locationName' => 'attribute',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
            ],
        ],
        'ResetNetworkInterfaceAttributeRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'SourceDestCheck' => ['shape' => 'String', 'locationName' => 'sourceDestCheck',],
            ],
        ],
        'ResetSnapshotAttributeRequest' => [
            'type' => 'structure',
            'required' => ['Attribute', 'SnapshotId',],
            'members' => [
                'Attribute' => ['shape' => 'SnapshotAttributeName',],
                'SnapshotId' => ['shape' => 'String',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'ResourceIdList' => ['type' => 'list', 'member' => ['shape' => 'String',],],
        'ResourceType' => [
            'type' => 'string',
            'enum' => [
                'customer-gateway',
                'dhcp-options',
                'image',
                'instance',
                'internet-gateway',
                'network-acl',
                'network-interface',
                'reserved-instances',
                'route-table',
                'snapshot',
                'spot-instances-request',
                'subnet',
                'security-group',
                'volume',
                'vpc',
                'vpn-connection',
                'vpn-gateway',
            ],
        ],
        'ResponseHostIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'ResponseHostIdSet' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'RestorableByStringList' => ['type' => 'list', 'member' => ['shape' => 'String',],],
        'RestoreAddressToClassicRequest' => [
            'type' => 'structure',
            'required' => ['PublicIp',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
            ],
        ],
        'RestoreAddressToClassicResult' => [
            'type' => 'structure',
            'members' => [
                'PublicIp' => ['shape' => 'String', 'locationName' => 'publicIp',],
                'Status' => ['shape' => 'Status', 'locationName' => 'status',],
            ],
        ],
        'RevokeSecurityGroupEgressRequest' => [
            'type' => 'structure',
            'required' => ['GroupId',],
            'members' => [
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
                'IpPermissions' => ['shape' => 'IpPermissionList', 'locationName' => 'ipPermissions',],
                'CidrIp' => ['shape' => 'String', 'locationName' => 'cidrIp',],
                'FromPort' => ['shape' => 'Integer', 'locationName' => 'fromPort',],
                'IpProtocol' => ['shape' => 'String', 'locationName' => 'ipProtocol',],
                'ToPort' => ['shape' => 'Integer', 'locationName' => 'toPort',],
                'SourceSecurityGroupName' => ['shape' => 'String', 'locationName' => 'sourceSecurityGroupName',],
                'SourceSecurityGroupOwnerId' => ['shape' => 'String', 'locationName' => 'sourceSecurityGroupOwnerId',],
            ],
        ],
        'RevokeSecurityGroupIngressRequest' => [
            'type' => 'structure',
            'members' => [
                'CidrIp' => ['shape' => 'String',],
                'FromPort' => ['shape' => 'Integer',],
                'GroupId' => ['shape' => 'String',],
                'GroupName' => ['shape' => 'String',],
                'IpPermissions' => ['shape' => 'IpPermissionList',],
                'IpProtocol' => ['shape' => 'String',],
                'SourceSecurityGroupName' => ['shape' => 'String',],
                'SourceSecurityGroupOwnerId' => ['shape' => 'String',],
                'ToPort' => ['shape' => 'Integer',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'Route' => [
            'type' => 'structure',
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String', 'locationName' => 'destinationCidrBlock',],
                'DestinationIpv6CidrBlock' => ['shape' => 'String', 'locationName' => 'destinationIpv6CidrBlock',],
                'DestinationPrefixListId' => ['shape' => 'String', 'locationName' => 'destinationPrefixListId',],
                'EgressOnlyInternetGatewayId' => [
                    'shape' => 'String',
                    'locationName' => 'egressOnlyInternetGatewayId',
                ],
                'GatewayId' => ['shape' => 'String', 'locationName' => 'gatewayId',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'InstanceOwnerId' => ['shape' => 'String', 'locationName' => 'instanceOwnerId',],
                'NatGatewayId' => ['shape' => 'String', 'locationName' => 'natGatewayId',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'Origin' => ['shape' => 'RouteOrigin', 'locationName' => 'origin',],
                'State' => ['shape' => 'RouteState', 'locationName' => 'state',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'RouteList' => ['type' => 'list', 'member' => ['shape' => 'Route', 'locationName' => 'item',],],
        'RouteOrigin' => [
            'type' => 'string',
            'enum' => ['CreateRouteTable', 'CreateRoute', 'EnableVgwRoutePropagation',],
        ],
        'RouteState' => ['type' => 'string', 'enum' => ['active', 'blackhole',],],
        'RouteTable' => [
            'type' => 'structure',
            'members' => [
                'Associations' => [
                    'shape' => 'RouteTableAssociationList',
                    'locationName' => 'associationSet',
                ],
                'PropagatingVgws' => ['shape' => 'PropagatingVgwList', 'locationName' => 'propagatingVgwSet',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
                'Routes' => ['shape' => 'RouteList', 'locationName' => 'routeSet',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'RouteTableAssociation' => [
            'type' => 'structure',
            'members' => [
                'Main' => ['shape' => 'Boolean', 'locationName' => 'main',],
                'RouteTableAssociationId' => ['shape' => 'String', 'locationName' => 'routeTableAssociationId',],
                'RouteTableId' => ['shape' => 'String', 'locationName' => 'routeTableId',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
            ],
        ],
        'RouteTableAssociationList' => [
            'type' => 'list',
            'member' => ['shape' => 'RouteTableAssociation', 'locationName' => 'item',],
        ],
        'RouteTableList' => ['type' => 'list', 'member' => ['shape' => 'RouteTable', 'locationName' => 'item',],],
        'RuleAction' => ['type' => 'string', 'enum' => ['allow', 'deny',],],
        'RunInstancesMonitoringEnabled' => [
            'type' => 'structure',
            'required' => ['Enabled',],
            'members' => ['Enabled' => ['shape' => 'Boolean', 'locationName' => 'enabled',],],
        ],
        'RunInstancesRequest' => [
            'type' => 'structure',
            'required' => ['ImageId', 'MaxCount', 'MinCount',],
            'members' => [
                'BlockDeviceMappings' => [
                    'shape' => 'BlockDeviceMappingRequestList',
                    'locationName' => 'BlockDeviceMapping',
                ],
                'ImageId' => ['shape' => 'String',],
                'InstanceType' => ['shape' => 'InstanceType',],
                'Ipv6AddressCount' => ['shape' => 'Integer',],
                'Ipv6Addresses' => ['shape' => 'InstanceIpv6AddressList', 'locationName' => 'Ipv6Address',],
                'KernelId' => ['shape' => 'String',],
                'KeyName' => ['shape' => 'String',],
                'MaxCount' => ['shape' => 'Integer',],
                'MinCount' => ['shape' => 'Integer',],
                'Monitoring' => ['shape' => 'RunInstancesMonitoringEnabled',],
                'Placement' => ['shape' => 'Placement',],
                'RamdiskId' => ['shape' => 'String',],
                'SecurityGroupIds' => ['shape' => 'SecurityGroupIdStringList', 'locationName' => 'SecurityGroupId',],
                'SecurityGroups' => ['shape' => 'SecurityGroupStringList', 'locationName' => 'SecurityGroup',],
                'SubnetId' => ['shape' => 'String',],
                'UserData' => ['shape' => 'String',],
                'AdditionalInfo' => ['shape' => 'String', 'locationName' => 'additionalInfo',],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'DisableApiTermination' => ['shape' => 'Boolean', 'locationName' => 'disableApiTermination',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'EbsOptimized' => ['shape' => 'Boolean', 'locationName' => 'ebsOptimized',],
                'IamInstanceProfile' => [
                    'shape' => 'IamInstanceProfileSpecification',
                    'locationName' => 'iamInstanceProfile',
                ],
                'InstanceInitiatedShutdownBehavior' => [
                    'shape' => 'ShutdownBehavior',
                    'locationName' => 'instanceInitiatedShutdownBehavior',
                ],
                'NetworkInterfaces' => [
                    'shape' => 'InstanceNetworkInterfaceSpecificationList',
                    'locationName' => 'networkInterface',
                ],
                'PrivateIpAddress' => ['shape' => 'String', 'locationName' => 'privateIpAddress',],
                'TagSpecifications' => ['shape' => 'TagSpecificationList', 'locationName' => 'TagSpecification',],
            ],
        ],
        'RunScheduledInstancesRequest' => [
            'type' => 'structure',
            'required' => ['LaunchSpecification', 'ScheduledInstanceId',],
            'members' => [
                'ClientToken' => ['shape' => 'String', 'idempotencyToken' => true,],
                'DryRun' => ['shape' => 'Boolean',],
                'InstanceCount' => ['shape' => 'Integer',],
                'LaunchSpecification' => ['shape' => 'ScheduledInstancesLaunchSpecification',],
                'ScheduledInstanceId' => ['shape' => 'String',],
            ],
        ],
        'RunScheduledInstancesResult' => [
            'type' => 'structure',
            'members' => ['InstanceIdSet' => ['shape' => 'InstanceIdSet', 'locationName' => 'instanceIdSet',],],
        ],
        'S3Storage' => [
            'type' => 'structure',
            'members' => [
                'AWSAccessKeyId' => ['shape' => 'String',],
                'Bucket' => ['shape' => 'String', 'locationName' => 'bucket',],
                'Prefix' => ['shape' => 'String', 'locationName' => 'prefix',],
                'UploadPolicy' => ['shape' => 'Blob', 'locationName' => 'uploadPolicy',],
                'UploadPolicySignature' => ['shape' => 'String', 'locationName' => 'uploadPolicySignature',],
            ],
        ],
        'ScheduledInstance' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'CreateDate' => ['shape' => 'DateTime', 'locationName' => 'createDate',],
                'HourlyPrice' => ['shape' => 'String', 'locationName' => 'hourlyPrice',],
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
                'NetworkPlatform' => ['shape' => 'String', 'locationName' => 'networkPlatform',],
                'NextSlotStartTime' => ['shape' => 'DateTime', 'locationName' => 'nextSlotStartTime',],
                'Platform' => ['shape' => 'String', 'locationName' => 'platform',],
                'PreviousSlotEndTime' => ['shape' => 'DateTime', 'locationName' => 'previousSlotEndTime',],
                'Recurrence' => ['shape' => 'ScheduledInstanceRecurrence', 'locationName' => 'recurrence',],
                'ScheduledInstanceId' => ['shape' => 'String', 'locationName' => 'scheduledInstanceId',],
                'SlotDurationInHours' => ['shape' => 'Integer', 'locationName' => 'slotDurationInHours',],
                'TermEndDate' => ['shape' => 'DateTime', 'locationName' => 'termEndDate',],
                'TermStartDate' => ['shape' => 'DateTime', 'locationName' => 'termStartDate',],
                'TotalScheduledInstanceHours' => [
                    'shape' => 'Integer',
                    'locationName' => 'totalScheduledInstanceHours',
                ],
            ],
        ],
        'ScheduledInstanceAvailability' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'AvailableInstanceCount' => ['shape' => 'Integer', 'locationName' => 'availableInstanceCount',],
                'FirstSlotStartTime' => ['shape' => 'DateTime', 'locationName' => 'firstSlotStartTime',],
                'HourlyPrice' => ['shape' => 'String', 'locationName' => 'hourlyPrice',],
                'InstanceType' => ['shape' => 'String', 'locationName' => 'instanceType',],
                'MaxTermDurationInDays' => ['shape' => 'Integer', 'locationName' => 'maxTermDurationInDays',],
                'MinTermDurationInDays' => ['shape' => 'Integer', 'locationName' => 'minTermDurationInDays',],
                'NetworkPlatform' => ['shape' => 'String', 'locationName' => 'networkPlatform',],
                'Platform' => ['shape' => 'String', 'locationName' => 'platform',],
                'PurchaseToken' => ['shape' => 'String', 'locationName' => 'purchaseToken',],
                'Recurrence' => ['shape' => 'ScheduledInstanceRecurrence', 'locationName' => 'recurrence',],
                'SlotDurationInHours' => ['shape' => 'Integer', 'locationName' => 'slotDurationInHours',],
                'TotalScheduledInstanceHours' => [
                    'shape' => 'Integer',
                    'locationName' => 'totalScheduledInstanceHours',
                ],
            ],
        ],
        'ScheduledInstanceAvailabilitySet' => [
            'type' => 'list',
            'member' => ['shape' => 'ScheduledInstanceAvailability', 'locationName' => 'item',],
        ],
        'ScheduledInstanceIdRequestSet' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'ScheduledInstanceId',],
        ],
        'ScheduledInstanceRecurrence' => [
            'type' => 'structure',
            'members' => [
                'Frequency' => ['shape' => 'String', 'locationName' => 'frequency',],
                'Interval' => ['shape' => 'Integer', 'locationName' => 'interval',],
                'OccurrenceDaySet' => ['shape' => 'OccurrenceDaySet', 'locationName' => 'occurrenceDaySet',],
                'OccurrenceRelativeToEnd' => ['shape' => 'Boolean', 'locationName' => 'occurrenceRelativeToEnd',],
                'OccurrenceUnit' => ['shape' => 'String', 'locationName' => 'occurrenceUnit',],
            ],
        ],
        'ScheduledInstanceRecurrenceRequest' => [
            'type' => 'structure',
            'members' => [
                'Frequency' => ['shape' => 'String',],
                'Interval' => ['shape' => 'Integer',],
                'OccurrenceDays' => ['shape' => 'OccurrenceDayRequestSet', 'locationName' => 'OccurrenceDay',],
                'OccurrenceRelativeToEnd' => ['shape' => 'Boolean',],
                'OccurrenceUnit' => ['shape' => 'String',],
            ],
        ],
        'ScheduledInstanceSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ScheduledInstance', 'locationName' => 'item',],
        ],
        'ScheduledInstancesBlockDeviceMapping' => [
            'type' => 'structure',
            'members' => [
                'DeviceName' => ['shape' => 'String',],
                'Ebs' => ['shape' => 'ScheduledInstancesEbs',],
                'NoDevice' => ['shape' => 'String',],
                'VirtualName' => ['shape' => 'String',],
            ],
        ],
        'ScheduledInstancesBlockDeviceMappingSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ScheduledInstancesBlockDeviceMapping', 'locationName' => 'BlockDeviceMapping',],
        ],
        'ScheduledInstancesEbs' => [
            'type' => 'structure',
            'members' => [
                'DeleteOnTermination' => ['shape' => 'Boolean',],
                'Encrypted' => ['shape' => 'Boolean',],
                'Iops' => ['shape' => 'Integer',],
                'SnapshotId' => ['shape' => 'String',],
                'VolumeSize' => ['shape' => 'Integer',],
                'VolumeType' => ['shape' => 'String',],
            ],
        ],
        'ScheduledInstancesIamInstanceProfile' => [
            'type' => 'structure',
            'members' => ['Arn' => ['shape' => 'String',], 'Name' => ['shape' => 'String',],],
        ],
        'ScheduledInstancesIpv6Address' => [
            'type' => 'structure',
            'members' => ['Ipv6Address' => ['shape' => 'Ipv6Address',],],
        ],
        'ScheduledInstancesIpv6AddressList' => [
            'type' => 'list',
            'member' => ['shape' => 'ScheduledInstancesIpv6Address', 'locationName' => 'Ipv6Address',],
        ],
        'ScheduledInstancesLaunchSpecification' => [
            'type' => 'structure',
            'required' => ['ImageId',],
            'members' => [
                'BlockDeviceMappings' => [
                    'shape' => 'ScheduledInstancesBlockDeviceMappingSet',
                    'locationName' => 'BlockDeviceMapping',
                ],
                'EbsOptimized' => ['shape' => 'Boolean',],
                'IamInstanceProfile' => ['shape' => 'ScheduledInstancesIamInstanceProfile',],
                'ImageId' => ['shape' => 'String',],
                'InstanceType' => ['shape' => 'String',],
                'KernelId' => ['shape' => 'String',],
                'KeyName' => ['shape' => 'String',],
                'Monitoring' => ['shape' => 'ScheduledInstancesMonitoring',],
                'NetworkInterfaces' => [
                    'shape' => 'ScheduledInstancesNetworkInterfaceSet',
                    'locationName' => 'NetworkInterface',
                ],
                'Placement' => ['shape' => 'ScheduledInstancesPlacement',],
                'RamdiskId' => ['shape' => 'String',],
                'SecurityGroupIds' => [
                    'shape' => 'ScheduledInstancesSecurityGroupIdSet',
                    'locationName' => 'SecurityGroupId',
                ],
                'SubnetId' => ['shape' => 'String',],
                'UserData' => ['shape' => 'String',],
            ],
        ],
        'ScheduledInstancesMonitoring' => [
            'type' => 'structure',
            'members' => ['Enabled' => ['shape' => 'Boolean',],],
        ],
        'ScheduledInstancesNetworkInterface' => [
            'type' => 'structure',
            'members' => [
                'AssociatePublicIpAddress' => ['shape' => 'Boolean',],
                'DeleteOnTermination' => ['shape' => 'Boolean',],
                'Description' => ['shape' => 'String',],
                'DeviceIndex' => ['shape' => 'Integer',],
                'Groups' => ['shape' => 'ScheduledInstancesSecurityGroupIdSet', 'locationName' => 'Group',],
                'Ipv6AddressCount' => ['shape' => 'Integer',],
                'Ipv6Addresses' => ['shape' => 'ScheduledInstancesIpv6AddressList', 'locationName' => 'Ipv6Address',],
                'NetworkInterfaceId' => ['shape' => 'String',],
                'PrivateIpAddress' => ['shape' => 'String',],
                'PrivateIpAddressConfigs' => [
                    'shape' => 'PrivateIpAddressConfigSet',
                    'locationName' => 'PrivateIpAddressConfig',
                ],
                'SecondaryPrivateIpAddressCount' => ['shape' => 'Integer',],
                'SubnetId' => ['shape' => 'String',],
            ],
        ],
        'ScheduledInstancesNetworkInterfaceSet' => [
            'type' => 'list',
            'member' => ['shape' => 'ScheduledInstancesNetworkInterface', 'locationName' => 'NetworkInterface',],
        ],
        'ScheduledInstancesPlacement' => [
            'type' => 'structure',
            'members' => ['AvailabilityZone' => ['shape' => 'String',], 'GroupName' => ['shape' => 'String',],],
        ],
        'ScheduledInstancesPrivateIpAddressConfig' => [
            'type' => 'structure',
            'members' => ['Primary' => ['shape' => 'Boolean',], 'PrivateIpAddress' => ['shape' => 'String',],],
        ],
        'ScheduledInstancesSecurityGroupIdSet' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'SecurityGroupId',],
        ],
        'SecurityGroup' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'groupDescription',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'IpPermissions' => ['shape' => 'IpPermissionList', 'locationName' => 'ipPermissions',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
                'IpPermissionsEgress' => ['shape' => 'IpPermissionList', 'locationName' => 'ipPermissionsEgress',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'SecurityGroupIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'SecurityGroupId',],
        ],
        'SecurityGroupList' => ['type' => 'list', 'member' => ['shape' => 'SecurityGroup', 'locationName' => 'item',],],
        'SecurityGroupReference' => [
            'type' => 'structure',
            'required' => ['GroupId', 'ReferencingVpcId',],
            'members' => [
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
                'ReferencingVpcId' => ['shape' => 'String', 'locationName' => 'referencingVpcId',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'SecurityGroupReferences' => [
            'type' => 'list',
            'member' => ['shape' => 'SecurityGroupReference', 'locationName' => 'item',],
        ],
        'SecurityGroupStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'SecurityGroup',],
        ],
        'ShutdownBehavior' => ['type' => 'string', 'enum' => ['stop', 'terminate',],],
        'SlotDateTimeRangeRequest' => [
            'type' => 'structure',
            'required' => ['EarliestTime', 'LatestTime',],
            'members' => ['EarliestTime' => ['shape' => 'DateTime',], 'LatestTime' => ['shape' => 'DateTime',],],
        ],
        'SlotStartTimeRangeRequest' => [
            'type' => 'structure',
            'members' => ['EarliestTime' => ['shape' => 'DateTime',], 'LatestTime' => ['shape' => 'DateTime',],],
        ],
        'Snapshot' => [
            'type' => 'structure',
            'members' => [
                'DataEncryptionKeyId' => ['shape' => 'String', 'locationName' => 'dataEncryptionKeyId',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'Encrypted' => ['shape' => 'Boolean', 'locationName' => 'encrypted',],
                'KmsKeyId' => ['shape' => 'String', 'locationName' => 'kmsKeyId',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'Progress' => ['shape' => 'String', 'locationName' => 'progress',],
                'SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
                'State' => ['shape' => 'SnapshotState', 'locationName' => 'status',],
                'StateMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
                'VolumeSize' => ['shape' => 'Integer', 'locationName' => 'volumeSize',],
                'OwnerAlias' => ['shape' => 'String', 'locationName' => 'ownerAlias',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'SnapshotAttributeName' => ['type' => 'string', 'enum' => ['productCodes', 'createVolumePermission',],],
        'SnapshotDetail' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DeviceName' => ['shape' => 'String', 'locationName' => 'deviceName',],
                'DiskImageSize' => ['shape' => 'Double', 'locationName' => 'diskImageSize',],
                'Format' => ['shape' => 'String', 'locationName' => 'format',],
                'Progress' => ['shape' => 'String', 'locationName' => 'progress',],
                'SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'Url' => ['shape' => 'String', 'locationName' => 'url',],
                'UserBucket' => ['shape' => 'UserBucketDetails', 'locationName' => 'userBucket',],
            ],
        ],
        'SnapshotDetailList' => [
            'type' => 'list',
            'member' => ['shape' => 'SnapshotDetail', 'locationName' => 'item',],
        ],
        'SnapshotDiskContainer' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String',],
                'Format' => ['shape' => 'String',],
                'Url' => ['shape' => 'String',],
                'UserBucket' => ['shape' => 'UserBucket',],
            ],
        ],
        'SnapshotIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'SnapshotId',],
        ],
        'SnapshotList' => ['type' => 'list', 'member' => ['shape' => 'Snapshot', 'locationName' => 'item',],],
        'SnapshotState' => ['type' => 'string', 'enum' => ['pending', 'completed', 'error',],],
        'SnapshotTaskDetail' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'DiskImageSize' => ['shape' => 'Double', 'locationName' => 'diskImageSize',],
                'Format' => ['shape' => 'String', 'locationName' => 'format',],
                'Progress' => ['shape' => 'String', 'locationName' => 'progress',],
                'SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'Url' => ['shape' => 'String', 'locationName' => 'url',],
                'UserBucket' => ['shape' => 'UserBucketDetails', 'locationName' => 'userBucket',],
            ],
        ],
        'SpotDatafeedSubscription' => [
            'type' => 'structure',
            'members' => [
                'Bucket' => ['shape' => 'String', 'locationName' => 'bucket',],
                'Fault' => ['shape' => 'SpotInstanceStateFault', 'locationName' => 'fault',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'Prefix' => ['shape' => 'String', 'locationName' => 'prefix',],
                'State' => ['shape' => 'DatafeedSubscriptionState', 'locationName' => 'state',],
            ],
        ],
        'SpotFleetLaunchSpecification' => [
            'type' => 'structure',
            'members' => [
                'SecurityGroups' => ['shape' => 'GroupIdentifierList', 'locationName' => 'groupSet',],
                'AddressingType' => ['shape' => 'String', 'locationName' => 'addressingType',],
                'BlockDeviceMappings' => ['shape' => 'BlockDeviceMappingList', 'locationName' => 'blockDeviceMapping',],
                'EbsOptimized' => ['shape' => 'Boolean', 'locationName' => 'ebsOptimized',],
                'IamInstanceProfile' => [
                    'shape' => 'IamInstanceProfileSpecification',
                    'locationName' => 'iamInstanceProfile',
                ],
                'ImageId' => ['shape' => 'String', 'locationName' => 'imageId',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'KernelId' => ['shape' => 'String', 'locationName' => 'kernelId',],
                'KeyName' => ['shape' => 'String', 'locationName' => 'keyName',],
                'Monitoring' => ['shape' => 'SpotFleetMonitoring', 'locationName' => 'monitoring',],
                'NetworkInterfaces' => [
                    'shape' => 'InstanceNetworkInterfaceSpecificationList',
                    'locationName' => 'networkInterfaceSet',
                ],
                'Placement' => ['shape' => 'SpotPlacement', 'locationName' => 'placement',],
                'RamdiskId' => ['shape' => 'String', 'locationName' => 'ramdiskId',],
                'SpotPrice' => ['shape' => 'String', 'locationName' => 'spotPrice',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'UserData' => ['shape' => 'String', 'locationName' => 'userData',],
                'WeightedCapacity' => ['shape' => 'Double', 'locationName' => 'weightedCapacity',],
            ],
        ],
        'SpotFleetMonitoring' => [
            'type' => 'structure',
            'members' => ['Enabled' => ['shape' => 'Boolean', 'locationName' => 'enabled',],],
        ],
        'SpotFleetRequestConfig' => [
            'type' => 'structure',
            'required' => ['CreateTime', 'SpotFleetRequestConfig', 'SpotFleetRequestId', 'SpotFleetRequestState',],
            'members' => [
                'ActivityStatus' => ['shape' => 'ActivityStatus', 'locationName' => 'activityStatus',],
                'CreateTime' => ['shape' => 'DateTime', 'locationName' => 'createTime',],
                'SpotFleetRequestConfig' => [
                    'shape' => 'SpotFleetRequestConfigData',
                    'locationName' => 'spotFleetRequestConfig',
                ],
                'SpotFleetRequestId' => ['shape' => 'String', 'locationName' => 'spotFleetRequestId',],
                'SpotFleetRequestState' => ['shape' => 'BatchState', 'locationName' => 'spotFleetRequestState',],
            ],
        ],
        'SpotFleetRequestConfigData' => [
            'type' => 'structure',
            'required' => ['IamFleetRole', 'LaunchSpecifications', 'SpotPrice', 'TargetCapacity',],
            'members' => [
                'AllocationStrategy' => ['shape' => 'AllocationStrategy', 'locationName' => 'allocationStrategy',],
                'ClientToken' => ['shape' => 'String', 'locationName' => 'clientToken',],
                'ExcessCapacityTerminationPolicy' => [
                    'shape' => 'ExcessCapacityTerminationPolicy',
                    'locationName' => 'excessCapacityTerminationPolicy',
                ],
                'FulfilledCapacity' => ['shape' => 'Double', 'locationName' => 'fulfilledCapacity',],
                'IamFleetRole' => ['shape' => 'String', 'locationName' => 'iamFleetRole',],
                'LaunchSpecifications' => ['shape' => 'LaunchSpecsList', 'locationName' => 'launchSpecifications',],
                'SpotPrice' => ['shape' => 'String', 'locationName' => 'spotPrice',],
                'TargetCapacity' => ['shape' => 'Integer', 'locationName' => 'targetCapacity',],
                'TerminateInstancesWithExpiration' => [
                    'shape' => 'Boolean',
                    'locationName' => 'terminateInstancesWithExpiration',
                ],
                'Type' => ['shape' => 'FleetType', 'locationName' => 'type',],
                'ValidFrom' => ['shape' => 'DateTime', 'locationName' => 'validFrom',],
                'ValidUntil' => ['shape' => 'DateTime', 'locationName' => 'validUntil',],
                'ReplaceUnhealthyInstances' => ['shape' => 'Boolean', 'locationName' => 'replaceUnhealthyInstances',],
            ],
        ],
        'SpotFleetRequestConfigSet' => [
            'type' => 'list',
            'member' => ['shape' => 'SpotFleetRequestConfig', 'locationName' => 'item',],
        ],
        'SpotInstanceRequest' => [
            'type' => 'structure',
            'members' => [
                'ActualBlockHourlyPrice' => ['shape' => 'String', 'locationName' => 'actualBlockHourlyPrice',],
                'AvailabilityZoneGroup' => ['shape' => 'String', 'locationName' => 'availabilityZoneGroup',],
                'BlockDurationMinutes' => ['shape' => 'Integer', 'locationName' => 'blockDurationMinutes',],
                'CreateTime' => ['shape' => 'DateTime', 'locationName' => 'createTime',],
                'Fault' => ['shape' => 'SpotInstanceStateFault', 'locationName' => 'fault',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'LaunchGroup' => ['shape' => 'String', 'locationName' => 'launchGroup',],
                'LaunchSpecification' => ['shape' => 'LaunchSpecification', 'locationName' => 'launchSpecification',],
                'LaunchedAvailabilityZone' => ['shape' => 'String', 'locationName' => 'launchedAvailabilityZone',],
                'ProductDescription' => ['shape' => 'RIProductDescription', 'locationName' => 'productDescription',],
                'SpotInstanceRequestId' => ['shape' => 'String', 'locationName' => 'spotInstanceRequestId',],
                'SpotPrice' => ['shape' => 'String', 'locationName' => 'spotPrice',],
                'State' => ['shape' => 'SpotInstanceState', 'locationName' => 'state',],
                'Status' => ['shape' => 'SpotInstanceStatus', 'locationName' => 'status',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'Type' => ['shape' => 'SpotInstanceType', 'locationName' => 'type',],
                'ValidFrom' => ['shape' => 'DateTime', 'locationName' => 'validFrom',],
                'ValidUntil' => ['shape' => 'DateTime', 'locationName' => 'validUntil',],
            ],
        ],
        'SpotInstanceRequestIdList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'SpotInstanceRequestId',],
        ],
        'SpotInstanceRequestList' => [
            'type' => 'list',
            'member' => ['shape' => 'SpotInstanceRequest', 'locationName' => 'item',],
        ],
        'SpotInstanceState' => ['type' => 'string', 'enum' => ['open', 'active', 'closed', 'cancelled', 'failed',],],
        'SpotInstanceStateFault' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'String', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'SpotInstanceStatus' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'String', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
                'UpdateTime' => ['shape' => 'DateTime', 'locationName' => 'updateTime',],
            ],
        ],
        'SpotInstanceType' => ['type' => 'string', 'enum' => ['one-time', 'persistent',],],
        'SpotPlacement' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'Tenancy' => ['shape' => 'Tenancy', 'locationName' => 'tenancy',],
            ],
        ],
        'SpotPrice' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'InstanceType' => ['shape' => 'InstanceType', 'locationName' => 'instanceType',],
                'ProductDescription' => ['shape' => 'RIProductDescription', 'locationName' => 'productDescription',],
                'SpotPrice' => ['shape' => 'String', 'locationName' => 'spotPrice',],
                'Timestamp' => ['shape' => 'DateTime', 'locationName' => 'timestamp',],
            ],
        ],
        'SpotPriceHistoryList' => ['type' => 'list', 'member' => ['shape' => 'SpotPrice', 'locationName' => 'item',],],
        'StaleIpPermission' => [
            'type' => 'structure',
            'members' => [
                'FromPort' => ['shape' => 'Integer', 'locationName' => 'fromPort',],
                'IpProtocol' => ['shape' => 'String', 'locationName' => 'ipProtocol',],
                'IpRanges' => ['shape' => 'IpRanges', 'locationName' => 'ipRanges',],
                'PrefixListIds' => ['shape' => 'PrefixListIdSet', 'locationName' => 'prefixListIds',],
                'ToPort' => ['shape' => 'Integer', 'locationName' => 'toPort',],
                'UserIdGroupPairs' => ['shape' => 'UserIdGroupPairSet', 'locationName' => 'groups',],
            ],
        ],
        'StaleIpPermissionSet' => [
            'type' => 'list',
            'member' => ['shape' => 'StaleIpPermission', 'locationName' => 'item',],
        ],
        'StaleSecurityGroup' => [
            'type' => 'structure',
            'required' => ['GroupId',],
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'StaleIpPermissions' => ['shape' => 'StaleIpPermissionSet', 'locationName' => 'staleIpPermissions',],
                'StaleIpPermissionsEgress' => [
                    'shape' => 'StaleIpPermissionSet',
                    'locationName' => 'staleIpPermissionsEgress',
                ],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'StaleSecurityGroupSet' => [
            'type' => 'list',
            'member' => ['shape' => 'StaleSecurityGroup', 'locationName' => 'item',],
        ],
        'StartInstancesRequest' => [
            'type' => 'structure',
            'required' => ['InstanceIds',],
            'members' => [
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'AdditionalInfo' => ['shape' => 'String', 'locationName' => 'additionalInfo',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'StartInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'StartingInstances' => [
                    'shape' => 'InstanceStateChangeList',
                    'locationName' => 'instancesSet',
                ],
            ],
        ],
        'State' => ['type' => 'string', 'enum' => ['Pending', 'Available', 'Deleting', 'Deleted',],],
        'StateReason' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'String', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'Status' => ['type' => 'string', 'enum' => ['MoveInProgress', 'InVpc', 'InClassic',],],
        'StatusName' => ['type' => 'string', 'enum' => ['reachability',],],
        'StatusType' => ['type' => 'string', 'enum' => ['passed', 'failed', 'insufficient-data', 'initializing',],],
        'StopInstancesRequest' => [
            'type' => 'structure',
            'required' => ['InstanceIds',],
            'members' => [
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
                'Force' => ['shape' => 'Boolean', 'locationName' => 'force',],
            ],
        ],
        'StopInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'StoppingInstances' => [
                    'shape' => 'InstanceStateChangeList',
                    'locationName' => 'instancesSet',
                ],
            ],
        ],
        'Storage' => ['type' => 'structure', 'members' => ['S3' => ['shape' => 'S3Storage',],],],
        'StorageLocation' => [
            'type' => 'structure',
            'members' => ['Bucket' => ['shape' => 'String',], 'Key' => ['shape' => 'String',],],
        ],
        'String' => ['type' => 'string',],
        'Subnet' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'AvailableIpAddressCount' => ['shape' => 'Integer', 'locationName' => 'availableIpAddressCount',],
                'CidrBlock' => ['shape' => 'String', 'locationName' => 'cidrBlock',],
                'DefaultForAz' => ['shape' => 'Boolean', 'locationName' => 'defaultForAz',],
                'MapPublicIpOnLaunch' => ['shape' => 'Boolean', 'locationName' => 'mapPublicIpOnLaunch',],
                'State' => ['shape' => 'SubnetState', 'locationName' => 'state',],
                'SubnetId' => ['shape' => 'String', 'locationName' => 'subnetId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
                'AssignIpv6AddressOnCreation' => [
                    'shape' => 'Boolean',
                    'locationName' => 'assignIpv6AddressOnCreation',
                ],
                'Ipv6CidrBlockAssociationSet' => [
                    'shape' => 'SubnetIpv6CidrBlockAssociationSet',
                    'locationName' => 'ipv6CidrBlockAssociationSet',
                ],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'SubnetCidrBlockState' => [
            'type' => 'structure',
            'members' => [
                'State' => ['shape' => 'SubnetCidrBlockStateCode', 'locationName' => 'state',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
            ],
        ],
        'SubnetCidrBlockStateCode' => [
            'type' => 'string',
            'enum' => ['associating', 'associated', 'disassociating', 'disassociated', 'failing', 'failed',],
        ],
        'SubnetIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'SubnetId',],],
        'SubnetIpv6CidrBlockAssociation' => [
            'type' => 'structure',
            'members' => [
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],
                'Ipv6CidrBlockState' => ['shape' => 'SubnetCidrBlockState', 'locationName' => 'ipv6CidrBlockState',],
            ],
        ],
        'SubnetIpv6CidrBlockAssociationSet' => [
            'type' => 'list',
            'member' => ['shape' => 'SubnetIpv6CidrBlockAssociation', 'locationName' => 'item',],
        ],
        'SubnetList' => ['type' => 'list', 'member' => ['shape' => 'Subnet', 'locationName' => 'item',],],
        'SubnetState' => ['type' => 'string', 'enum' => ['pending', 'available',],],
        'SummaryStatus' => [
            'type' => 'string',
            'enum' => ['ok', 'impaired', 'insufficient-data', 'not-applicable', 'initializing',],
        ],
        'Tag' => [
            'type' => 'structure',
            'members' => [
                'Key' => ['shape' => 'String', 'locationName' => 'key',],
                'Value' => ['shape' => 'String', 'locationName' => 'value',],
            ],
        ],
        'TagDescription' => [
            'type' => 'structure',
            'members' => [
                'Key' => ['shape' => 'String', 'locationName' => 'key',],
                'ResourceId' => ['shape' => 'String', 'locationName' => 'resourceId',],
                'ResourceType' => ['shape' => 'ResourceType', 'locationName' => 'resourceType',],
                'Value' => ['shape' => 'String', 'locationName' => 'value',],
            ],
        ],
        'TagDescriptionList' => [
            'type' => 'list',
            'member' => ['shape' => 'TagDescription', 'locationName' => 'item',],
        ],
        'TagList' => ['type' => 'list', 'member' => ['shape' => 'Tag', 'locationName' => 'item',],],
        'TagSpecification' => [
            'type' => 'structure',
            'members' => [
                'ResourceType' => ['shape' => 'ResourceType', 'locationName' => 'resourceType',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'Tag',],
            ],
        ],
        'TagSpecificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'TagSpecification', 'locationName' => 'item',],
        ],
        'TargetConfiguration' => [
            'type' => 'structure',
            'members' => [
                'InstanceCount' => ['shape' => 'Integer', 'locationName' => 'instanceCount',],
                'OfferingId' => ['shape' => 'String', 'locationName' => 'offeringId',],
            ],
        ],
        'TargetConfigurationRequest' => [
            'type' => 'structure',
            'required' => ['OfferingId',],
            'members' => ['InstanceCount' => ['shape' => 'Integer',], 'OfferingId' => ['shape' => 'String',],],
        ],
        'TargetConfigurationRequestSet' => [
            'type' => 'list',
            'member' => ['shape' => 'TargetConfigurationRequest', 'locationName' => 'TargetConfigurationRequest',],
        ],
        'TargetReservationValue' => [
            'type' => 'structure',
            'members' => [
                'ReservationValue' => ['shape' => 'ReservationValue', 'locationName' => 'reservationValue',],
                'TargetConfiguration' => ['shape' => 'TargetConfiguration', 'locationName' => 'targetConfiguration',],
            ],
        ],
        'TargetReservationValueSet' => [
            'type' => 'list',
            'member' => ['shape' => 'TargetReservationValue', 'locationName' => 'item',],
        ],
        'TelemetryStatus' => ['type' => 'string', 'enum' => ['UP', 'DOWN',],],
        'Tenancy' => ['type' => 'string', 'enum' => ['default', 'dedicated', 'host',],],
        'TerminateInstancesRequest' => [
            'type' => 'structure',
            'required' => ['InstanceIds',],
            'members' => [
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'TerminateInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'TerminatingInstances' => [
                    'shape' => 'InstanceStateChangeList',
                    'locationName' => 'instancesSet',
                ],
            ],
        ],
        'TrafficType' => ['type' => 'string', 'enum' => ['ACCEPT', 'REJECT', 'ALL',],],
        'UnassignIpv6AddressesRequest' => [
            'type' => 'structure',
            'required' => ['Ipv6Addresses', 'NetworkInterfaceId',],
            'members' => [
                'Ipv6Addresses' => ['shape' => 'Ipv6AddressList', 'locationName' => 'ipv6Addresses',],
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
            ],
        ],
        'UnassignIpv6AddressesResult' => [
            'type' => 'structure',
            'members' => [
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'UnassignedIpv6Addresses' => [
                    'shape' => 'Ipv6AddressList',
                    'locationName' => 'unassignedIpv6Addresses',
                ],
            ],
        ],
        'UnassignPrivateIpAddressesRequest' => [
            'type' => 'structure',
            'required' => ['NetworkInterfaceId', 'PrivateIpAddresses',],
            'members' => [
                'NetworkInterfaceId' => ['shape' => 'String', 'locationName' => 'networkInterfaceId',],
                'PrivateIpAddresses' => [
                    'shape' => 'PrivateIpAddressStringList',
                    'locationName' => 'privateIpAddress',
                ],
            ],
        ],
        'UnmonitorInstancesRequest' => [
            'type' => 'structure',
            'required' => ['InstanceIds',],
            'members' => [
                'InstanceIds' => ['shape' => 'InstanceIdStringList', 'locationName' => 'InstanceId',],
                'DryRun' => ['shape' => 'Boolean', 'locationName' => 'dryRun',],
            ],
        ],
        'UnmonitorInstancesResult' => [
            'type' => 'structure',
            'members' => [
                'InstanceMonitorings' => [
                    'shape' => 'InstanceMonitoringList',
                    'locationName' => 'instancesSet',
                ],
            ],
        ],
        'UnsuccessfulItem' => [
            'type' => 'structure',
            'required' => ['Error',],
            'members' => [
                'Error' => ['shape' => 'UnsuccessfulItemError', 'locationName' => 'error',],
                'ResourceId' => ['shape' => 'String', 'locationName' => 'resourceId',],
            ],
        ],
        'UnsuccessfulItemError' => [
            'type' => 'structure',
            'required' => ['Code', 'Message',],
            'members' => [
                'Code' => ['shape' => 'String', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'UnsuccessfulItemList' => [
            'type' => 'list',
            'member' => ['shape' => 'UnsuccessfulItem', 'locationName' => 'item',],
        ],
        'UnsuccessfulItemSet' => [
            'type' => 'list',
            'member' => ['shape' => 'UnsuccessfulItem', 'locationName' => 'item',],
        ],
        'UserBucket' => [
            'type' => 'structure',
            'members' => ['S3Bucket' => ['shape' => 'String',], 'S3Key' => ['shape' => 'String',],],
        ],
        'UserBucketDetails' => [
            'type' => 'structure',
            'members' => [
                'S3Bucket' => ['shape' => 'String', 'locationName' => 's3Bucket',],
                'S3Key' => ['shape' => 'String', 'locationName' => 's3Key',],
            ],
        ],
        'UserData' => [
            'type' => 'structure',
            'members' => ['Data' => ['shape' => 'String', 'locationName' => 'data',],],
        ],
        'UserGroupStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'UserGroup',],],
        'UserIdGroupPair' => [
            'type' => 'structure',
            'members' => [
                'GroupId' => ['shape' => 'String', 'locationName' => 'groupId',],
                'GroupName' => ['shape' => 'String', 'locationName' => 'groupName',],
                'PeeringStatus' => ['shape' => 'String', 'locationName' => 'peeringStatus',],
                'UserId' => ['shape' => 'String', 'locationName' => 'userId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'UserIdGroupPairList' => [
            'type' => 'list',
            'member' => ['shape' => 'UserIdGroupPair', 'locationName' => 'item',],
        ],
        'UserIdGroupPairSet' => [
            'type' => 'list',
            'member' => ['shape' => 'UserIdGroupPair', 'locationName' => 'item',],
        ],
        'UserIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'UserId',],],
        'ValueStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'item',],],
        'VgwTelemetry' => [
            'type' => 'structure',
            'members' => [
                'AcceptedRouteCount' => ['shape' => 'Integer', 'locationName' => 'acceptedRouteCount',],
                'LastStatusChange' => ['shape' => 'DateTime', 'locationName' => 'lastStatusChange',],
                'OutsideIpAddress' => ['shape' => 'String', 'locationName' => 'outsideIpAddress',],
                'Status' => ['shape' => 'TelemetryStatus', 'locationName' => 'status',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
            ],
        ],
        'VgwTelemetryList' => ['type' => 'list', 'member' => ['shape' => 'VgwTelemetry', 'locationName' => 'item',],],
        'VirtualizationType' => ['type' => 'string', 'enum' => ['hvm', 'paravirtual',],],
        'Volume' => [
            'type' => 'structure',
            'members' => [
                'Attachments' => ['shape' => 'VolumeAttachmentList', 'locationName' => 'attachmentSet',],
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'CreateTime' => ['shape' => 'DateTime', 'locationName' => 'createTime',],
                'Encrypted' => ['shape' => 'Boolean', 'locationName' => 'encrypted',],
                'KmsKeyId' => ['shape' => 'String', 'locationName' => 'kmsKeyId',],
                'Size' => ['shape' => 'Integer', 'locationName' => 'size',],
                'SnapshotId' => ['shape' => 'String', 'locationName' => 'snapshotId',],
                'State' => ['shape' => 'VolumeState', 'locationName' => 'status',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
                'Iops' => ['shape' => 'Integer', 'locationName' => 'iops',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VolumeType' => ['shape' => 'VolumeType', 'locationName' => 'volumeType',],
            ],
        ],
        'VolumeAttachment' => [
            'type' => 'structure',
            'members' => [
                'AttachTime' => ['shape' => 'DateTime', 'locationName' => 'attachTime',],
                'Device' => ['shape' => 'String', 'locationName' => 'device',],
                'InstanceId' => ['shape' => 'String', 'locationName' => 'instanceId',],
                'State' => ['shape' => 'VolumeAttachmentState', 'locationName' => 'status',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
                'DeleteOnTermination' => ['shape' => 'Boolean', 'locationName' => 'deleteOnTermination',],
            ],
        ],
        'VolumeAttachmentList' => [
            'type' => 'list',
            'member' => ['shape' => 'VolumeAttachment', 'locationName' => 'item',],
        ],
        'VolumeAttachmentState' => ['type' => 'string', 'enum' => ['attaching', 'attached', 'detaching', 'detached',],],
        'VolumeAttributeName' => ['type' => 'string', 'enum' => ['autoEnableIO', 'productCodes',],],
        'VolumeDetail' => [
            'type' => 'structure',
            'required' => ['Size',],
            'members' => ['Size' => ['shape' => 'Long', 'locationName' => 'size',],],
        ],
        'VolumeIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'VolumeId',],],
        'VolumeList' => ['type' => 'list', 'member' => ['shape' => 'Volume', 'locationName' => 'item',],],
        'VolumeModification' => [
            'type' => 'structure',
            'members' => [
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
                'ModificationState' => ['shape' => 'VolumeModificationState', 'locationName' => 'modificationState',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
                'TargetSize' => ['shape' => 'Integer', 'locationName' => 'targetSize',],
                'TargetIops' => ['shape' => 'Integer', 'locationName' => 'targetIops',],
                'TargetVolumeType' => ['shape' => 'VolumeType', 'locationName' => 'targetVolumeType',],
                'OriginalSize' => ['shape' => 'Integer', 'locationName' => 'originalSize',],
                'OriginalIops' => ['shape' => 'Integer', 'locationName' => 'originalIops',],
                'OriginalVolumeType' => ['shape' => 'VolumeType', 'locationName' => 'originalVolumeType',],
                'Progress' => ['shape' => 'Long', 'locationName' => 'progress',],
                'StartTime' => ['shape' => 'DateTime', 'locationName' => 'startTime',],
                'EndTime' => ['shape' => 'DateTime', 'locationName' => 'endTime',],
            ],
        ],
        'VolumeModificationList' => [
            'type' => 'list',
            'member' => ['shape' => 'VolumeModification', 'locationName' => 'item',],
        ],
        'VolumeModificationState' => [
            'type' => 'string',
            'enum' => ['modifying', 'optimizing', 'completed', 'failed',],
        ],
        'VolumeState' => [
            'type' => 'string',
            'enum' => ['creating', 'available', 'in-use', 'deleting', 'deleted', 'error',],
        ],
        'VolumeStatusAction' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'String', 'locationName' => 'code',],
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'EventId' => ['shape' => 'String', 'locationName' => 'eventId',],
                'EventType' => ['shape' => 'String', 'locationName' => 'eventType',],
            ],
        ],
        'VolumeStatusActionsList' => [
            'type' => 'list',
            'member' => ['shape' => 'VolumeStatusAction', 'locationName' => 'item',],
        ],
        'VolumeStatusDetails' => [
            'type' => 'structure',
            'members' => [
                'Name' => ['shape' => 'VolumeStatusName', 'locationName' => 'name',],
                'Status' => ['shape' => 'String', 'locationName' => 'status',],
            ],
        ],
        'VolumeStatusDetailsList' => [
            'type' => 'list',
            'member' => ['shape' => 'VolumeStatusDetails', 'locationName' => 'item',],
        ],
        'VolumeStatusEvent' => [
            'type' => 'structure',
            'members' => [
                'Description' => ['shape' => 'String', 'locationName' => 'description',],
                'EventId' => ['shape' => 'String', 'locationName' => 'eventId',],
                'EventType' => ['shape' => 'String', 'locationName' => 'eventType',],
                'NotAfter' => ['shape' => 'DateTime', 'locationName' => 'notAfter',],
                'NotBefore' => ['shape' => 'DateTime', 'locationName' => 'notBefore',],
            ],
        ],
        'VolumeStatusEventsList' => [
            'type' => 'list',
            'member' => ['shape' => 'VolumeStatusEvent', 'locationName' => 'item',],
        ],
        'VolumeStatusInfo' => [
            'type' => 'structure',
            'members' => [
                'Details' => ['shape' => 'VolumeStatusDetailsList', 'locationName' => 'details',],
                'Status' => ['shape' => 'VolumeStatusInfoStatus', 'locationName' => 'status',],
            ],
        ],
        'VolumeStatusInfoStatus' => ['type' => 'string', 'enum' => ['ok', 'impaired', 'insufficient-data',],],
        'VolumeStatusItem' => [
            'type' => 'structure',
            'members' => [
                'Actions' => ['shape' => 'VolumeStatusActionsList', 'locationName' => 'actionsSet',],
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'Events' => ['shape' => 'VolumeStatusEventsList', 'locationName' => 'eventsSet',],
                'VolumeId' => ['shape' => 'String', 'locationName' => 'volumeId',],
                'VolumeStatus' => ['shape' => 'VolumeStatusInfo', 'locationName' => 'volumeStatus',],
            ],
        ],
        'VolumeStatusList' => [
            'type' => 'list',
            'member' => ['shape' => 'VolumeStatusItem', 'locationName' => 'item',],
        ],
        'VolumeStatusName' => ['type' => 'string', 'enum' => ['io-enabled', 'io-performance',],],
        'VolumeType' => ['type' => 'string', 'enum' => ['standard', 'io1', 'gp2', 'sc1', 'st1',],],
        'Vpc' => [
            'type' => 'structure',
            'members' => [
                'CidrBlock' => ['shape' => 'String', 'locationName' => 'cidrBlock',],
                'DhcpOptionsId' => ['shape' => 'String', 'locationName' => 'dhcpOptionsId',],
                'State' => ['shape' => 'VpcState', 'locationName' => 'state',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
                'InstanceTenancy' => ['shape' => 'Tenancy', 'locationName' => 'instanceTenancy',],
                'Ipv6CidrBlockAssociationSet' => [
                    'shape' => 'VpcIpv6CidrBlockAssociationSet',
                    'locationName' => 'ipv6CidrBlockAssociationSet',
                ],
                'IsDefault' => ['shape' => 'Boolean', 'locationName' => 'isDefault',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'VpcAttachment' => [
            'type' => 'structure',
            'members' => [
                'State' => ['shape' => 'AttachmentStatus', 'locationName' => 'state',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'VpcAttachmentList' => ['type' => 'list', 'member' => ['shape' => 'VpcAttachment', 'locationName' => 'item',],],
        'VpcAttributeName' => ['type' => 'string', 'enum' => ['enableDnsSupport', 'enableDnsHostnames',],],
        'VpcCidrBlockState' => [
            'type' => 'structure',
            'members' => [
                'State' => ['shape' => 'VpcCidrBlockStateCode', 'locationName' => 'state',],
                'StatusMessage' => ['shape' => 'String', 'locationName' => 'statusMessage',],
            ],
        ],
        'VpcCidrBlockStateCode' => [
            'type' => 'string',
            'enum' => ['associating', 'associated', 'disassociating', 'disassociated', 'failing', 'failed',],
        ],
        'VpcClassicLink' => [
            'type' => 'structure',
            'members' => [
                'ClassicLinkEnabled' => ['shape' => 'Boolean', 'locationName' => 'classicLinkEnabled',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'VpcClassicLinkIdList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'VpcId',],],
        'VpcClassicLinkList' => [
            'type' => 'list',
            'member' => ['shape' => 'VpcClassicLink', 'locationName' => 'item',],
        ],
        'VpcEndpoint' => [
            'type' => 'structure',
            'members' => [
                'CreationTimestamp' => ['shape' => 'DateTime', 'locationName' => 'creationTimestamp',],
                'PolicyDocument' => ['shape' => 'String', 'locationName' => 'policyDocument',],
                'RouteTableIds' => ['shape' => 'ValueStringList', 'locationName' => 'routeTableIdSet',],
                'ServiceName' => ['shape' => 'String', 'locationName' => 'serviceName',],
                'State' => ['shape' => 'State', 'locationName' => 'state',],
                'VpcEndpointId' => ['shape' => 'String', 'locationName' => 'vpcEndpointId',],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'VpcEndpointSet' => ['type' => 'list', 'member' => ['shape' => 'VpcEndpoint', 'locationName' => 'item',],],
        'VpcIdStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'VpcId',],],
        'VpcIpv6CidrBlockAssociation' => [
            'type' => 'structure',
            'members' => [
                'AssociationId' => ['shape' => 'String', 'locationName' => 'associationId',],
                'Ipv6CidrBlock' => ['shape' => 'String', 'locationName' => 'ipv6CidrBlock',],
                'Ipv6CidrBlockState' => ['shape' => 'VpcCidrBlockState', 'locationName' => 'ipv6CidrBlockState',],
            ],
        ],
        'VpcIpv6CidrBlockAssociationSet' => [
            'type' => 'list',
            'member' => ['shape' => 'VpcIpv6CidrBlockAssociation', 'locationName' => 'item',],
        ],
        'VpcList' => ['type' => 'list', 'member' => ['shape' => 'Vpc', 'locationName' => 'item',],],
        'VpcPeeringConnection' => [
            'type' => 'structure',
            'members' => [
                'AccepterVpcInfo' => [
                    'shape' => 'VpcPeeringConnectionVpcInfo',
                    'locationName' => 'accepterVpcInfo',
                ],
                'ExpirationTime' => ['shape' => 'DateTime', 'locationName' => 'expirationTime',],
                'RequesterVpcInfo' => ['shape' => 'VpcPeeringConnectionVpcInfo', 'locationName' => 'requesterVpcInfo',],
                'Status' => ['shape' => 'VpcPeeringConnectionStateReason', 'locationName' => 'status',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VpcPeeringConnectionId' => ['shape' => 'String', 'locationName' => 'vpcPeeringConnectionId',],
            ],
        ],
        'VpcPeeringConnectionList' => [
            'type' => 'list',
            'member' => ['shape' => 'VpcPeeringConnection', 'locationName' => 'item',],
        ],
        'VpcPeeringConnectionOptionsDescription' => [
            'type' => 'structure',
            'members' => [
                'AllowDnsResolutionFromRemoteVpc' => [
                    'shape' => 'Boolean',
                    'locationName' => 'allowDnsResolutionFromRemoteVpc',
                ],
                'AllowEgressFromLocalClassicLinkToRemoteVpc' => [
                    'shape' => 'Boolean',
                    'locationName' => 'allowEgressFromLocalClassicLinkToRemoteVpc',
                ],
                'AllowEgressFromLocalVpcToRemoteClassicLink' => [
                    'shape' => 'Boolean',
                    'locationName' => 'allowEgressFromLocalVpcToRemoteClassicLink',
                ],
            ],
        ],
        'VpcPeeringConnectionStateReason' => [
            'type' => 'structure',
            'members' => [
                'Code' => ['shape' => 'VpcPeeringConnectionStateReasonCode', 'locationName' => 'code',],
                'Message' => ['shape' => 'String', 'locationName' => 'message',],
            ],
        ],
        'VpcPeeringConnectionStateReasonCode' => [
            'type' => 'string',
            'enum' => [
                'initiating-request',
                'pending-acceptance',
                'active',
                'deleted',
                'rejected',
                'failed',
                'expired',
                'provisioning',
                'deleting',
            ],
        ],
        'VpcPeeringConnectionVpcInfo' => [
            'type' => 'structure',
            'members' => [
                'CidrBlock' => ['shape' => 'String', 'locationName' => 'cidrBlock',],
                'Ipv6CidrBlockSet' => ['shape' => 'Ipv6CidrBlockSet', 'locationName' => 'ipv6CidrBlockSet',],
                'OwnerId' => ['shape' => 'String', 'locationName' => 'ownerId',],
                'PeeringOptions' => [
                    'shape' => 'VpcPeeringConnectionOptionsDescription',
                    'locationName' => 'peeringOptions',
                ],
                'VpcId' => ['shape' => 'String', 'locationName' => 'vpcId',],
            ],
        ],
        'VpcState' => ['type' => 'string', 'enum' => ['pending', 'available',],],
        'VpnConnection' => [
            'type' => 'structure',
            'members' => [
                'CustomerGatewayConfiguration' => [
                    'shape' => 'String',
                    'locationName' => 'customerGatewayConfiguration',
                ],
                'CustomerGatewayId' => ['shape' => 'String', 'locationName' => 'customerGatewayId',],
                'State' => ['shape' => 'VpnState', 'locationName' => 'state',],
                'Type' => ['shape' => 'GatewayType', 'locationName' => 'type',],
                'VpnConnectionId' => ['shape' => 'String', 'locationName' => 'vpnConnectionId',],
                'VpnGatewayId' => ['shape' => 'String', 'locationName' => 'vpnGatewayId',],
                'Options' => ['shape' => 'VpnConnectionOptions', 'locationName' => 'options',],
                'Routes' => ['shape' => 'VpnStaticRouteList', 'locationName' => 'routes',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
                'VgwTelemetry' => ['shape' => 'VgwTelemetryList', 'locationName' => 'vgwTelemetry',],
            ],
        ],
        'VpnConnectionIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'VpnConnectionId',],
        ],
        'VpnConnectionList' => ['type' => 'list', 'member' => ['shape' => 'VpnConnection', 'locationName' => 'item',],],
        'VpnConnectionOptions' => [
            'type' => 'structure',
            'members' => ['StaticRoutesOnly' => ['shape' => 'Boolean', 'locationName' => 'staticRoutesOnly',],],
        ],
        'VpnConnectionOptionsSpecification' => [
            'type' => 'structure',
            'members' => ['StaticRoutesOnly' => ['shape' => 'Boolean', 'locationName' => 'staticRoutesOnly',],],
        ],
        'VpnGateway' => [
            'type' => 'structure',
            'members' => [
                'AvailabilityZone' => ['shape' => 'String', 'locationName' => 'availabilityZone',],
                'State' => ['shape' => 'VpnState', 'locationName' => 'state',],
                'Type' => ['shape' => 'GatewayType', 'locationName' => 'type',],
                'VpcAttachments' => ['shape' => 'VpcAttachmentList', 'locationName' => 'attachments',],
                'VpnGatewayId' => ['shape' => 'String', 'locationName' => 'vpnGatewayId',],
                'Tags' => ['shape' => 'TagList', 'locationName' => 'tagSet',],
            ],
        ],
        'VpnGatewayIdStringList' => [
            'type' => 'list',
            'member' => ['shape' => 'String', 'locationName' => 'VpnGatewayId',],
        ],
        'VpnGatewayList' => ['type' => 'list', 'member' => ['shape' => 'VpnGateway', 'locationName' => 'item',],],
        'VpnState' => ['type' => 'string', 'enum' => ['pending', 'available', 'deleting', 'deleted',],],
        'VpnStaticRoute' => [
            'type' => 'structure',
            'members' => [
                'DestinationCidrBlock' => ['shape' => 'String', 'locationName' => 'destinationCidrBlock',],
                'Source' => ['shape' => 'VpnStaticRouteSource', 'locationName' => 'source',],
                'State' => ['shape' => 'VpnState', 'locationName' => 'state',],
            ],
        ],
        'VpnStaticRouteList' => [
            'type' => 'list',
            'member' => ['shape' => 'VpnStaticRoute', 'locationName' => 'item',],
        ],
        'VpnStaticRouteSource' => ['type' => 'string', 'enum' => ['Static',],],
        'ZoneNameStringList' => ['type' => 'list', 'member' => ['shape' => 'String', 'locationName' => 'ZoneName',],],
        'scope' => ['type' => 'string', 'enum' => ['Availability Zone', 'Region',],],
    ],
];
