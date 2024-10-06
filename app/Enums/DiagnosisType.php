<?php

namespace App\Enums;

enum DiagnosisType: string
{
    case NoRecipeTypeTag = 'no_tag';
    case BadAssetAlt = 'bad_asset_alt';
    case DescriptionTooLong = 'description_too_long';
    case BannerAltTooLong = 'banner_alt_too_long';
    case NoHotColdTag = 'no_hot_cold_tag';
    case InitialMaybeAddSeason = 'initial_maybe_add_season';
    case CorruptedImage = 'corrupted_image';
}
