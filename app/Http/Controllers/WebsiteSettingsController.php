<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingsController extends Controller
{
    public function index()
    {
        // Get homepage theme
        $homepageTheme = Setting::getValue('homepage_theme', 'index');

        // Get current slider images for each page
        $pages = [
            'homepage' => 'Homepage',
            'flights' => 'Flights',
            'hotels' => 'Hotels',
            'cars' => 'Cars',
            'trains' => 'Trains',
            'tours' => 'Tours',
            'buses' => 'Buses',
            'esim' => 'eSIM',
            'cruises' => 'Cruises',
            'resources' => 'Resources',
            'faqs' => 'FAQs',
            'contact' => 'Contact Us'
        ];

        $pageSliders = [];
        foreach ($pages as $key => $name) {
            $sliders = json_decode(Setting::getValue($key . '_sliders', '[]'), true);
            // Ensure we have 4 slots
            while (count($sliders) < 4) {
                $sliders[] = null;
            }
            $pageSliders[$key] = $sliders;
        }

        // Get available homepage themes
        $availableThemes = [
            'index' => 'Theme 1 (Default)',
            'index-2' => 'Theme 2',
            'index-3' => 'Theme 3',
            'index-4' => 'Theme 4',
            'index-5' => 'Theme 5',
            'index-6' => 'Theme 6',
            'index-7' => 'Theme 7',
            'index-rtl' => 'RTL Theme'
        ];

        // Get theme settings
        $theme = Setting::getValue('theme', 'light');

        // Get flight pricing settings
        $flightTaxRate = Setting::getValue('flight_tax_rate', 0);
        $flightTaxEnabled = Setting::getValue('flight_tax_enabled', false);
        $flightDiscountEnabled = Setting::getValue('flight_discount_enabled', false);
        $flightDiscountRate = Setting::getValue('flight_discount_rate', 0);

        return view('admin.website-settings', compact('pageSliders', 'pages', 'homepageTheme', 'availableThemes', 'theme', 'flightTaxRate', 'flightTaxEnabled', 'flightDiscountEnabled', 'flightDiscountRate'));
    }

    public function updateSliders(Request $request, $page)
    {
        $request->validate([
            'sliders.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:20480', // 20MB max (increased for videos)
        ]);

        $currentSliders = json_decode(Setting::getValue($page . '_sliders', '[]'), true);

        // Handle new uploads and keep existing ones
        $updatedSliders = [];
        for ($i = 0; $i < 4; $i++) {
            if ($request->hasFile("sliders.{$i}")) {
                // Delete old image if exists
                if (isset($currentSliders[$i]) && $currentSliders[$i]) {
                    Storage::disk('public')->delete($currentSliders[$i]);
                }

                // Store new image
                $file = $request->file("sliders.{$i}");
                $filename = $page . '_slider_' . ($i + 1) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('sliders', $filename, 'public');

                $updatedSliders[] = $path;
            } elseif (isset($currentSliders[$i])) {
                // Keep existing image
                $updatedSliders[] = $currentSliders[$i];
            } else {
                $updatedSliders[] = null;
            }
        }

        // Remove null values at the end
        while (count($updatedSliders) > 0 && end($updatedSliders) === null) {
            array_pop($updatedSliders);
        }

        Setting::setValue($page . '_sliders', json_encode($updatedSliders), 'appearance', ucfirst($page) . ' slider images');

        return redirect()->back()->with('success', ucfirst($page) . ' slider images updated successfully!');
    }

    public function deleteSlider(Request $request, $page, $index)
    {
        $currentSliders = json_decode(Setting::getValue($page . '_sliders', '[]'), true);

        if (isset($currentSliders[$index]) && $currentSliders[$index]) {
            // Delete the file
            Storage::disk('public')->delete($currentSliders[$index]);

            // Remove from array
            unset($currentSliders[$index]);

            // Reindex array
            $currentSliders = array_values($currentSliders);

            Setting::setValue($page . '_sliders', json_encode($currentSliders), 'appearance', ucfirst($page) . ' slider images');
        }

        return redirect()->back()->with('success', ucfirst($page) . ' slider image deleted successfully!');
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
        ]);

        Setting::setValue('theme', $request->theme, 'appearance', 'Website theme setting');

        return redirect()->back()->with('success', 'Theme updated successfully!');
    }

    public function updateHomepageTheme(Request $request)
    {
        $request->validate([
            'homepage_theme' => 'required|string',
        ]);

        $availableThemes = ['index', 'index-2', 'index-3', 'index-4', 'index-5', 'index-6', 'index-7', 'index-rtl'];

        if (!in_array($request->homepage_theme, $availableThemes)) {
            return redirect()->back()->with('error', 'Invalid homepage theme selected.');
        }

        Setting::setValue('homepage_theme', $request->homepage_theme, 'appearance', 'Homepage theme selection');

        return redirect()->back()->with('success', 'Homepage theme updated successfully!');
    }

    public function updateBackgrounds(Request $request)
    {
        $request->validate([
            'client_section_bg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'update_section_bg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'about_section_bg1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'about_section_bg2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'testimonial_section_bg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $backgroundFields = [
            'client_section_bg',
            'update_section_bg',
            'about_section_bg1',
            'about_section_bg2',
            'testimonial_section_bg'
        ];

        foreach ($backgroundFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                $oldImage = Setting::getValue($field);
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                // Store new image
                $file = $request->file($field);
                $filename = 'backgrounds/' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('backgrounds', $filename, 'public');

                Setting::setValue($field, $path, 'appearance', ucfirst(str_replace('_', ' ', $field)));
            }
        }

        return redirect()->back()->with('success', 'Background images updated successfully!');
    }

    public function deleteBackground(Request $request, $backgroundKey)
    {
        $validKeys = [
            'client_section_bg',
            'update_section_bg',
            'about_section_bg1',
            'about_section_bg2',
            'testimonial_section_bg'
        ];

        if (!in_array($backgroundKey, $validKeys)) {
            return redirect()->back()->with('error', 'Invalid background key.');
        }

        $imagePath = Setting::getValue($backgroundKey);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Setting::setValue($backgroundKey, null, 'appearance', ucfirst(str_replace('_', ' ', $backgroundKey)));
        }

        return redirect()->back()->with('success', 'Background image deleted successfully!');
    }

    public function updateSliderContent(Request $request)
    {
        $request->validate([
            'slider_title' => 'required|string|max:500',
            'slider_description' => 'required|string|max:1000',
        ]);

        Setting::setValue('slider_title', $request->slider_title, 'appearance', 'Homepage slider title');
        Setting::setValue('slider_description', $request->slider_description, 'appearance', 'Homepage slider description');

        return redirect()->back()->with('success', 'Slider content updated successfully!');
    }

    public function updateFlightPricing(Request $request)
    {
        $request->validate([
            'flight_tax_rate' => 'required|numeric|min:0|max:100',
            'flight_discount_rate' => 'required|numeric|min:0|max:100',
            'flight_tax_enabled' => 'nullable|boolean',
            'flight_discount_enabled' => 'nullable|boolean',
        ]);

        Setting::setValue('flight_tax_rate', $request->flight_tax_rate, 'flight_pricing', 'Flight tax rate percentage');
        Setting::setValue('flight_discount_rate', $request->flight_discount_rate, 'flight_pricing', 'Flight discount rate percentage');
        Setting::setValue('flight_tax_enabled', $request->boolean('flight_tax_enabled', false), 'flight_pricing', 'Enable flight tax display');
        Setting::setValue('flight_discount_enabled', $request->boolean('flight_discount_enabled', false), 'flight_pricing', 'Enable flight discount display');

        return redirect()->back()->with('success', 'Flight pricing settings updated successfully!');
    }
}
