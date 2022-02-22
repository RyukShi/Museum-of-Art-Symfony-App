<?php

namespace App\Data;

class SearchData
{
    public int $page = 1;

    // Artist
    public string $display_name;
    public string $begin_date;
    public string $end_date;
    public string $gender;
    public string $nationality;

    // Artwork
    public string $number;
    public string $name;
    public string $title;
    public string $dimensions;
    public string $medium;

    // Classification
    public string $classification;

    // DatingArtwork
    public string $object_date;
    public int $object_begin_date;
    public int $object_end_date;

    // Localisation
    public string $culture;
    public string $period;
    public string $dynasty;
    public string $reign;
    public string $region;
    public string $subregion;
    public string $country;
    public string $county;
    public string $city;
    public string $locale;
    public string $locus;
    public string $river;
    public string $excavation;
}
