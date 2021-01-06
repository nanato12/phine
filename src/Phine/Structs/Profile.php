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
 * User profile object
 *
 * @property string|null $userId        ユーザーID
 * @property string|null $displayName   表示名
 * @property string|null $pictureUrl    プロフィール画像URL
 * @property string|null $language      使用言語
 * @property string|null $statusMessage ステータスメッセージ
 */
class Profile
{
    public $userId = null;
    public $displayName = null;
    public $pictureUrl = null;
    public $language = null;
    public $statusMessage = null;
}
