<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Common\Models;

use MicrosoftAzure\Storage\Common\Internal\Resources;
use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Common\Internal\Validate;

/**
 * Holds access policy elements
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class AccessPolicy
{
    private $start;
    private $expiry;
    private $permission;
    private $resourceType;

    /**
     * Get the valid permissions for the given resource.
     * This is not a constant array due to PHP does not support constant array
     * until 5.6
     *
     * @return array
     */
    public static function getResourceValidPermissions()
    {
        static $validPermissions = [
            Resources::RESOURCE_TYPE_BLOB => ['r', 'a', 'c', 'w', 'd'],
            Resources::RESOURCE_TYPE_CONTAINER => ['r', 'a', 'c', 'w', 'd', 'l'],
            Resources::RESOURCE_TYPE_QUEUE => ['r', 'a', 'u', 'p'],
            Resources::RESOURCE_TYPE_TABLE => ['r', 'a', 'u', 'd'],
            Resources::RESOURCE_TYPE_FILE => ['r', 'c', 'w', 'd'],
            Resources::RESOURCE_TYPE_SHARE => ['r', 'c', 'w', 'd', 'l']
        ];

        return $validPermissions;
    }

    /**
     * Constructor
     *
     * @param string $resourceType the resource type of this access policy.
     */
    public function __construct($resourceType = Resources::RESOURCE_TYPE_BLOB)
    {
        Validate::isString($resourceType, 'resourceType');
        Validate::isTrue(
            $resourceType == Resources::RESOURCE_TYPE_BLOB ||
            $resourceType == Resources::RESOURCE_TYPE_CONTAINER ||
            $resourceType == Resources::RESOURCE_TYPE_QUEUE ||
            $resourceType == Resources::RESOURCE_TYPE_TABLE ||
            $resourceType == Resources::RESOURCE_TYPE_FILE ||
            $resourceType == Resources::RESOURCE_TYPE_SHARE,
            Resources::ERROR_RESOURCE_TYPE_NOT_SUPPORTED
        );

        $this->resourceType = $resourceType;
    }

    /**
     * Gets start.
     *
     * @return \DateTime.
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets start.
     *
     * @param \DateTime $start value.
     *
     * @return void
     */
    public function setStart(\DateTime $start = null)
    {
        if ($start != null) {
            Validate::isDate($start);
        }
        $this->start = $start;
    }

    /**
     * Gets expiry.
     *
     * @return \DateTime.
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * Sets expiry.
     *
     * @param \DateTime $expiry value.
     *
     * @return void
     */
    public function setExpiry($expiry)
    {
        Validate::isDate($expiry);
        $this->expiry = $expiry;
    }

    /**
     * Gets permission.
     *
     * @return string.
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Sets permission.
     *
     * @param string $permission value.
     *
     * @return void
     *@throws \InvalidArgumentException
     *
     */
    public function setPermission($permission)
    {
        $this->permission = $this->validatePermission($permission);
    }

    /**
     * Gets resource type.
     *
     * @return string.
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * Validate the permission against its corresponding allowed permissions
     *
     * @param string $permission The permission to be validated.
     *
     * @return string
     *@throws \InvalidArgumentException
     *
     */
    private function validatePermission($permission)
    {
        $validPermissions =
            self::getResourceValidPermissions()[$this->getResourceType()];
        $result = '';
        foreach ($validPermissions as $validPermission) {
            if (strpos($permission, $validPermission) !== false) {
                //append the valid permission to result.
                $result .= $validPermission;
                //remove all the character that represents the permission.
                $permission = str_replace(
                    $validPermission,
                    '',
                    $permission
                );
            }
        }
        //After filtering all the permissions, if there is still characters
        //left in the given permission, throw exception.
        Validate::isTrue(
            $permission == '',
            sprintf(
                Resources::INVALID_PERMISSION_PROVIDED,
                $this->getResourceType(),
                implode(', ', $validPermissions)
            )
        );

        return $result;
    }

    /**
     * Converts this current object to XML representation.
     *
     * @return array
     *@internal
     *
     */
    public function toArray()
    {
        $array = array();

        if ($this->getStart() != null) {
            $array[Resources::XTAG_SIGNED_START] =
                Utilities::convertToEdmDateTime($this->getStart());
        }
        $array[Resources::XTAG_SIGNED_EXPIRY] =
            Utilities::convertToEdmDateTime($this->getExpiry());
        $array[Resources::XTAG_SIGNED_PERMISSION] = $this->getPermission();

        return $array;
    }
}
