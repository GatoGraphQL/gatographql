<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;

// Extension: adding more conditionals: has_attendees and no_attendees
HooksAPIFacade::getInstance()->addFilter('em_event_output_show_condition', 'gdEmEventOutputShowCondition', 10, 4);
function gdEmEventOutputShowCondition($show_condition = false, $condition, $conditional_value, $event)
{
    if ($condition == 'has_attendees') {
        return gdEventHasAttendees($event);
    } elseif ($condition == 'no_attendees') {
        return !gdEventHasAttendees($event);
    }

    return $show_condition;
}


/*
 * Check for if the Event has a given Attribute
 */
HooksAPIFacade::getInstance()->addFilter('em_event_output_show_condition', 'gdEmEventOutputShowConditionAddAttCondition', 1, 4);
function gdEmEventOutputShowConditionAddAttCondition($show_condition = false, $condition, $conditional_value, $event)
{
    if (preg_match('/^has_att_([a-zA-Z0-9_\-]+)$/', $condition, $tag_match)) {
        //event has this attribute
        $att = $tag_match[1];
        $attributes = $event->event_attributes;

        $show_condition = is_array($event->event_attributes) && array_key_exists($att, $attributes) && $attributes[$att];
    } elseif (preg_match('/^no_att_([a-zA-Z0-9_\-]+)$/', $condition, $tag_match)) {
        //event doesn't have this attribute
        $att = $tag_match[1];
        $attributes = $event->event_attributes;

        $show_condition = !(is_array($event->event_attributes) && array_key_exists($att, $attributes) && $attributes[$att]);
    }

    return $show_condition;
}

/*
 * Check for if the Event is held either today or tomorrow
 */
HooksAPIFacade::getInstance()->addFilter('em_event_output_show_condition', 'gdEmEventOutputShowConditionAddDateCondition', 11, 4);
function gdEmEventOutputShowConditionAddDateCondition($show_condition = false, $condition, $conditional_value, $event)
{
    if ($condition == 'is_today') {
        $today = date('Y-m-d', POP_CONSTANT_CURRENTTIMESTAMP);
        $show_condition = gdEmEventEventOnGivenDay($today, $event);
    } elseif ($condition == 'is_tomorrow') {
        $tomorrow = date('Y-m-d', POP_CONSTANT_CURRENTTIMESTAMP+86400);    // add a day
        $show_condition = gdEmEventEventOnGivenDay($tomorrow, $event);
    }

    return $show_condition;
}

HooksAPIFacade::getInstance()->addFilter('em_event_output_placeholder', 'gdEmEventOutputEventAuthor', 10, 4);
function gdEmEventOutputEventAuthor($output, $event, $format, $target)
{
    $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
    preg_match_all("/(#@?_?[A-Za-z0-9]+)({([a-zA-Z0-9_,]+)})?/", $format, $placeholders);
    foreach ($placeholders[1] as $key => $result) {
        switch ($result) {
            case '#_EVENTAUTHOR':
                $author = $event->event_owner;
                $name = $cmsusersapi->getUserDisplayName($author);
                $url = $cmsusersapi->getUserURL($author);
                $output = sprintf(
                    '<a href="%s">%s</a>',
                    $url,
                    $name
                );
                break;

            case '#_EVENTAUTHORNAME':
                $author = $event->event_owner;
                $output = $cmsusersapi->getUserDisplayName($author);
                break;

            case '#_EVENTAUTHORURL':
                $author = $event->event_owner;
                $url = $cmsusersapi->getUserURL($author);
                $output = $url;
                break;
        }
    }

    return $output;
}

/*
 * For the FullCalendar
 */
HooksAPIFacade::getInstance()->addFilter('em_event_output_placeholder', 'gdEmEventOutputEventDates', 10, 4);
function gdEmEventOutputEventDates($attString, $event, $format, $target)
{
    preg_match_all("/(#@?_?[A-Za-z0-9]+)({([a-zA-Z0-9_,]+)})?/", $format, $placeholders);
    foreach ($placeholders[1] as $key => $result) {
        switch ($result) {
            case '#_EVENTDATESTART':
            case '#_EVENTDATEEND':
                // $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
                //$date_format = ( $cmsengineapi->getOption('dbem_date_format') ) ? getOption('dbem_date_format'):getOption(NameResolverFacade::getInstance()->getName('popcms:option:dateFormat'));
                // Possible Formats required: http://arshaw.com/fullcalendar/docs/event_data/Event_Object/
                // WP Formats: http://codex.wordpress.org/Formatting_Date_and_Time
                $date_format = 'c'; // ISO8601

                if ($result == '#_EVENTDATESTART') {
                    $date = $event->start;
                } else {
                    $date = $event->end;
                }
                $attString = date_i18n($date_format, $date);
                break;

            case '#_EVENTALLDAY':
                $attString = $event->event_all_day;
                break;
        }
    }

    return $attString;
}
