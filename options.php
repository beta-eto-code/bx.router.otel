<?php

global $USER;
global $APPLICATION;

if (!$USER->IsAdmin()) {
    return;
}
