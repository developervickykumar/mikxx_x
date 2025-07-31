<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function updateTheme(Request $request)
    {
        $theme = $request->input('theme');
        if (in_array($theme, ['light', 'dark'])) {
            session(['theme' => $theme]);
            return response()->json(['success' => true, 'theme' => $theme]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid theme'], 400);
    }

    public function updateLanguage(Request $request)
    {
        $locale = $request->input('locale');
        $validLocales = [
            'en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'zh',
            'hi', 'bn', 'ta', 'te', 'mr', 'gu', 'kn', 'ml', 'pa', 'or',
            'ks', 'kok', 'mni', 'ne', 'sa', 'ar', 'ja', 'ko', 'tr', 'nl',
            'pl', 'vi', 'th', 'id', 'sv'
        ];
        
        if (!in_array($locale, $validLocales)) {
            return response()->json(['error' => 'Invalid language'], 400);
        }
        
        session(['locale' => $locale]);
        return response()->json(['success' => true]);
    }

    public function updateCurrency(Request $request)
    {
        $currency = $request->input('currency');
        $validCurrencies = [
            // Major World Currencies
            'USD', // US Dollar
            'EUR', // Euro
            'GBP', // British Pound
            'JPY', // Japanese Yen
            'CNY', // Chinese Yuan
            'INR', // Indian Rupee
            'CAD', // Canadian Dollar
            'AUD', // Australian Dollar
            'CHF', // Swiss Franc
            
            // Asian Currencies
            'HKD', // Hong Kong Dollar
            'SGD', // Singapore Dollar
            'KRW', // South Korean Won
            'TWD', // Taiwan Dollar
            'THB', // Thai Baht
            'MYR', // Malaysian Ringgit
            'IDR', // Indonesian Rupiah
            'PHP', // Philippine Peso
            'VND', // Vietnamese Dong
            
            // Middle Eastern Currencies
            'AED', // UAE Dirham
            'SAR', // Saudi Riyal
            'QAR', // Qatari Riyal
            'KWD', // Kuwaiti Dinar
            'BHD', // Bahraini Dinar
            
            // European Currencies
            'SEK', // Swedish Krona
            'NOK', // Norwegian Krone
            'DKK', // Danish Krone
            'PLN', // Polish Złoty
            'CZK', // Czech Koruna
            'HUF', // Hungarian Forint
            'RON', // Romanian Leu
            
            // Latin American Currencies
            'MXN', // Mexican Peso
            'BRL', // Brazilian Real
            'ARS', // Argentine Peso
            'CLP', // Chilean Peso
            'COP', // Colombian Peso
            'PEN', // Peruvian Sol
            
            // African Currencies
            'ZAR', // South African Rand
            'EGP', // Egyptian Pound
            'NGN', // Nigerian Naira
            'KES', // Kenyan Shilling
            'MAD', // Moroccan Dirham
            
            // Other Major Currencies
            'NZD', // New Zealand Dollar
            'ILS', // Israeli New Shekel
            'TRY', // Turkish Lira
            'RUB', // Russian Ruble
        ];
        
        if (!in_array($currency, $validCurrencies)) {
            return response()->json(['success' => false, 'message' => 'Invalid currency'], 400);
        }
        
        session(['currency' => $currency]);
        return response()->json(['success' => true, 'currency' => $currency]);
    }

    public function updateTimezone(Request $request)
    {
        $timezone = $request->input('timezone');
        if (in_array($timezone, timezone_identifiers_list())) {
            session(['timezone' => $timezone]);
            return response()->json(['success' => true, 'timezone' => $timezone]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid timezone'], 400);
    }
} 