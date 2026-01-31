<?php

namespace Database\Seeders;

use App\Models\InventorySource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'Ad Colony',
            'Ad Media',
            'Ad Mob',
            'Ad Unity',
            'Adjoe',
            'Adtelligent',
            'AOL (enx)',
            'AppLovin',
            'AppNexus',
            'Appodeal',
            'Baidu',
            'Bidswitch',
            'C Exchange',
            'Chartboost',
            'CheetahMobileAdx',
            'DV-360',
            'EPOM',
            'Fyber',
            'Geniee',
            'Google AdX',
            'Huawei',
            'HueAds',
            'Index Exchange',
            'inneractive',
            'IronSource',
            'Media.net',
            'MGID',
            'Mobfox',
            'MobilityWare',
            'MoPub',
            'One by AOL',
            'Open X',
            'Opera',
            'Outbrain',
            'PubMatic',
            'PubNative',
            'ReklamStore',
            'RTBDemand',
            'Rubicon',
            'Samsung',
            'silvermob',
            'Smaato',
            'Smart Ads',
            'SmartyAds',
            'SpotXchange',
            'Taboola',
            'TripleLift',
            'UC Browser',
            'Unity Ads',
            'Verizon',
            'VertaMedia',
            'Vungle',
            'Yahoo Exchange',
        ];

        foreach ($sources as $source) {
            InventorySource::create([
                'name' => $source,
            ]);
        }
    }
}

