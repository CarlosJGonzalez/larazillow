<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'];

    protected $sortable = ['price', 'created_at'];
    
    public function owner() : BelongsTo {
        return $this->belongsTo( 
            \App\Models\User::class,
            'by_user_id'
        );
    }

    public function offers(): HasMany
    {
        return $this->hasMany(
            \App\Models\Offer::class,
            'listing_id'
        );
    }
    
    public function myimages():HasMany
    {
        return $this->hasMany(
            \App\Models\ListingImage::class
        );
    }
    public function scopeMostRecent( $query ){
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeWithoutSold( Builder $query ): Builder
    {
        return $query->whereNull('sold_at');
        // return $query->doesntHave('offers')
        //     ->orWhereHas('offers', function( Builder $query ){
        //         $query->whereNull('accepted_at')
        //             ->whereNull('rejected_at');
        //     });
    }
    public function scopeFilter( Builder $query, array $filters ) : Builder
    {
        return $query->when( 
                $filters['priceFrom'] ?? false,
                fn( $query, $value ) => $query->where( 'price', '>=', $value ) 
            )->when( 
                $filters['priceTo'] ?? false,
                fn( $query, $value ) => $query->where( 'price', '<=', $value )                
            )->when( 
                $filters['beds'] ?? false,
                fn( $query, $value ) => $query->where( 'beds', (int)$value < 6 ? '=' : '>=', $value )                
            )->when( 
                $filters['baths'] ?? false,
                fn( $query, $value ) => $query->where( 'baths', (int)$value < 6 ? '=' : '>=', $value )                
            )->when( 
                $filters['areaFrom'] ?? false,
                fn( $query, $value ) => $query->where( 'area', '>=', $value )                
            )->when( 
                $filters['areaTo'] ?? false,
                fn( $query, $value ) => $query->where( 'area', '<=', $value )                
            )->when(
                $filters['deleted'] ?? false,
                fn( $query, $value) => $query->withTrashed()
            )->when(
                $filters['by'] ?? false,
                fn( $query, $value ) => 
                    !in_array( $value, $this->sortable )
                    ? $query :
                    $query->orderBy( $value, $filters['order'] ?? 'desc' )
            );
    }
}
