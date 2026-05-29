<?php
defined('ABSPATH') || exit;

class BDC_AI_Chat {

    private static $responses = array(
        'bunaken'   => 'Bunaken is famous for its spectacular vertical wall diving! The walls drop to over 200m with incredible coral coverage. We offer day trips, dive & stay packages, and liveaboard cruises. Best visibility is from April to October. Would you like to see our Bunaken packages?',
        'lembeh'    => 'Lembeh Strait is the world capital of muck diving! You can find rare critters like mimic octopus, flamboyant cuttlefish, rhinopias, and hairy frogfish. Our experienced guides know exactly where to find them. Best conditions are year-round.',
        'siladen'   => 'Siladen offers pristine reef gardens with excellent visibility (20-35m). It\'s perfect for both beginners and experienced divers. The shallow reefs are also great for snorkeling. Just 35 minutes from Manado!',
        'bangka'    => 'Bangka Island features dramatic underwater landscapes with pinnacles, soft corals, and unique rock formations. The currents can be exciting for advanced divers, while calm bays suit beginners. About 90 minutes from Manado.',
        'price'     => 'Our prices vary by season and activity. Day trips start from $75 (low season) to $120 (peak season). Liveaboards from $220-$350/night. Dive courses from $420-$550. Would you like a specific quote?',
        'course'    => 'We offer SSI courses from Open Water Diver through Divemaster. Our Open Water course takes 3-4 days and includes all equipment, certification, and boat dives. No prior experience needed! We also offer specialty courses like Deep, Night, Navigation, and Underwater Photography.',
        'liveaboard'=> 'Our liveaboards range from 3 to 7 nights, visiting Bunaken, Bangka, and Lembeh. All meals, dives, and equipment are included. Cabins are air-conditioned with private bathrooms. Would you like to see specific boat details?',
        'water sport'=> 'We offer snorkeling, kayaking, stand-up paddleboarding, jet skiing, and banana boat rides. Perfect for non-divers or as a surface interval activity!',
        'hotel'     => 'We partner with hotels in Manado ranging from budget guesthouses ($40/night) to luxury resorts ($150+/night). All our partner hotels offer airport pickup and easy access to our dive center.',
        'default'   => 'Thank you for your interest in Babarida Dive Center! I can help you with information about our destinations (Bunaken, Siladen, Bangka, Lembeh), dive courses, liveaboards, pricing, hotels, and water sports. What would you like to know more about?',
    );

    public static function get_response($message) {
        $msg = strtolower($message);
        foreach (self::$responses as $keyword => $response) {
            if ($keyword === 'default') continue;
            if (strpos($msg, $keyword) !== false) return $response;
        }
        // Check for common questions
        if (strpos($msg, 'how much') !== false || strpos($msg, 'cost') !== false || strpos($msg, 'harga') !== false) return self::$responses['price'];
        if (strpos($msg, 'learn') !== false || strpos($msg, 'certif') !== false || strpos($msg, 'kursus') !== false) return self::$responses['course'];
        if (strpos($msg, 'stay') !== false || strpos($msg, 'accommod') !== false || strpos($msg, 'hotel') !== false) return self::$responses['hotel'];
        if (strpos($msg, 'boat') !== false || strpos($msg, 'cruise') !== false) return self::$responses['liveaboard'];
        return self::$responses['default'];
    }
}
