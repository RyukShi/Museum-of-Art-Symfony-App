<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use App\Entity\Artist, App\Entity\Artwork, App\Entity\Classification, App\Entity\DatingArtwork, App\Entity\Localisation;
use League\Csv\Statement;
use Doctrine\Common\Collections\ArrayCollection;

class AppFixtures extends Fixture
{
    // just for visualization of headerFile
    private $headerFile = array(
        0 => "Object Number",
        1 => "Is Highlight",
        2 => "Is Timeline Work",
        3 => "Is Public Domain",
        4 => "Object ID",
        5 => "Gallery Number",
        6 => "Department",
        7 => "AccessionYear",
        8 => "Object Name",
        9 => "Title",
        10 => "Culture",
        11 => "Period",
        12 => "Dynasty",
        13 => "Reign",
        14 => "Portfolio",
        15 => "Constituent ID",
        16 => "Artist Role",
        17 => "Artist Prefix",
        18 => "Artist Display Name",
        19 => "Artist Display Bio",
        20 => "Artist Suffix",
        21 => "Artist Alpha Sort",
        22 => "Artist Nationality",
        23 => "Artist Begin Date",
        24 => "Artist End Date",
        25 => "Artist Gender",
        26 => "Artist ULAN URL",
        27 => "Artist Wikidata URL",
        28 => "Object Date",
        29 => "Object Begin Date",
        30 => "Object End Date",
        31 => "Medium",
        32 => "Dimensions",
        33 => "Credit Line",
        34 => "Geography Type",
        35 => "City",
        36 => "State",
        37 => "County",
        38 => "Country",
        39 => "Region",
        40 => "Subregion",
        41 => "Locale",
        42 => "Locus",
        43 => "Excavation",
        44 => "River",
        45 => "Classification",
        46 => "Rights and Reproduction",
        47 => "Link Resource",
        48 => "Object Wikidata URL",
        49 => "Metadata Date",
        50 => "Repository",
        51 => "Tags",
        52 => "Tags AAT URL",
        53 => "Tags Wikidata URL"
    );

    public function load(ObjectManager $manager): void
    {
        // filter entities in order to load them separately
        $loadArwork = false;
        $loadArtist = false;
        $loadClassification = true;
        $loadDatingArtwork = false;
        $loadLocalisation = false;

        // reader file
        $stream = fopen('C:/Users/Public/Documents/MetObjects.csv', 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        $stmt = Statement::create()
            ->offset(15000)
            ->limit(15000);

        $records = $stmt->process($csv);

        // to avoid duplicates artists
        if ($loadArtist)
            $ArtistDisplayName = new ArrayCollection();

        // to avoid duplicates classifications
        if ($loadClassification)
            $classificationArray = new ArrayCollection();

        foreach ($records as $record) {

            if ($loadArtist) {
                // Artist Fixtures
                if ($record["Artist Display Name"] != null && !$ArtistDisplayName->contains($record["Artist Display Name"])) {
                    $ArtistDisplayName->add($record["Artist Display Name"]);
                    $artist = new Artist(
                        $record["Artist Display Name"],
                        $record["Artist Begin Date"],
                        $record["Artist End Date"],
                        $record["Artist Gender"],
                        $record["Artist Nationality"]
                    );
                    $manager->persist($artist);
                }
            }

            if ($loadArwork) {
                // Artwork Fixtures
                if ($record["Title"] != null) {
                    $artwork = new Artwork(
                        $record["Object Number"],
                        $record["Object Name"],
                        $record["Title"],
                        $record["Dimensions"],
                        $record["Medium"]
                    );
                    $manager->persist($artwork);
                }
            }

            if ($loadClassification) {
                // Classification Fixtures
                if ($record["Classification"] != null && !$classificationArray->contains($record["Classification"])) {
                    $classification = new Classification($record["Classification"]);
                    $classificationArray->add($record["Classification"]);
                    $manager->persist($classification);
                }
            }

            if ($loadDatingArtwork) {
                // DatingArtwork Fixtures
                if ($record["Object Begin Date"] != null && $record["Object End Date"] != null) {
                    $datingArtwork = new DatingArtwork(
                        $record["Object Begin Date"],
                        $record["Object End Date"]
                    );
                    $manager->persist($datingArtwork);
                }
            }

            if ($loadLocalisation) {
                // Localisation Fixtures
                if ($record["Country"] != null && $record["Region"] != null) {
                    $localisation = new Localisation(
                        $record["Culture"],
                        $record["Period"],
                        $record["Dynasty"],
                        $record["Reign"],
                        $record["Region"],
                        $record["Subregion"],
                        $record["Country"],
                        $record["County"],
                        $record["City"],
                        $record["Locale"],
                        $record["Locus"],
                        $record["River"],
                        $record["Excavation"]
                    );
                    $manager->persist($localisation);
                }
            }
        }

        // clear all ArrayCollection
        if ($loadArtist)
            $ArtistDisplayName->clear();

        if ($loadClassification)
            $classificationArray->clear();

        $manager->flush();
    }
}
