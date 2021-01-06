<?php

/**
 * Copyright 2020 nanato12
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Phine\Structs;

/**
 * Group object
 *
 * @property string|null $groupId グループID
 * @property string|null $groupName グループ名
 * @property string|null $pictureUrl グループ画像URL
 * @property int|null    $count メンバー人数（公式アカウントは含めない, LINE WORKSなども）
 */
class Group
{
    public $groupId = null;
    public $groupName = null;
    public $pictureUrl = null;
    public $count = null;
}
