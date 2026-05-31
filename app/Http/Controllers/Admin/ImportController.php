<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImportController extends Controller {

    public function index() {
        return view('admin.import.index');
    }

    public function downloadTemplate() {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="products_template.csv"',
        ];
        $callback = function() {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($f, ['name_ar','name_en','category_id','active_ingredient','manufacturer','price','sale_price','stock','min_stock_alert','dosage_form','strength','package_size','requires_prescription','is_featured','barcode','description_ar','description_en']);
            fputcsv($f, ['بنادول اكسترا','Panadol Extra','1','باراسيتامول + كافيين','GSK','15.50','','100','10','Tablet','500mg+65mg','24 tablets','0','0','6001060001','يستخدم لتخفيف الآلام والحمى','Used for pain and fever relief']);
            fclose($f);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request) {
        $request->validate(['file' => 'required|file|mimes:csv,txt|max:5120']);

        $file      = $request->file('file');
        $handle    = fopen($file->getPathname(), 'r');
        $headers   = fgetcsv($handle); // skip header row
        $imported  = 0;
        $errors    = [];
        $row       = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $row++;
            if (count($data) < 5) { $errors[] = "Row $row: insufficient columns"; continue; }

            try {
                $mapped = array_combine(array_slice($headers, 0, count($data)), $data);

                // Validate category
                $catId = intval($mapped['category_id'] ?? 0);
                if (!Category::find($catId)) { $errors[] = "Row $row: category_id '$catId' not found"; continue; }

                $slug = Str::slug($mapped['name_en'] ?? '') . '-' . uniqid();

                Product::updateOrCreate(
                    ['barcode' => $mapped['barcode'] ?: null, 'slug' => $slug],
                    [
                        'name_ar'               => $mapped['name_ar'],
                        'name_en'               => $mapped['name_en'],
                        'slug'                  => $slug,
                        'category_id'           => $catId,
                        'active_ingredient'     => $mapped['active_ingredient'] ?? null,
                        'manufacturer'          => $mapped['manufacturer'] ?? null,
                        'price'                 => floatval($mapped['price'] ?? 0),
                        'sale_price'            => !empty($mapped['sale_price']) ? floatval($mapped['sale_price']) : null,
                        'stock'                 => intval($mapped['stock'] ?? 0),
                        'min_stock_alert'       => intval($mapped['min_stock_alert'] ?? 10),
                        'dosage_form'           => $mapped['dosage_form'] ?? null,
                        'strength'              => $mapped['strength'] ?? null,
                        'package_size'          => $mapped['package_size'] ?? null,
                        'requires_prescription' => ($mapped['requires_prescription'] ?? '0') == '1',
                        'is_featured'           => ($mapped['is_featured'] ?? '0') == '1',
                        'barcode'               => $mapped['barcode'] ?: null,
                        'description_ar'        => $mapped['description_ar'] ?? null,
                        'description_en'        => $mapped['description_en'] ?? null,
                        'is_active'             => true,
                    ]
                );
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row $row: " . $e->getMessage();
            }
        }
        fclose($handle);

        $msg = "تم استيراد $imported منتج بنجاح";
        if ($errors) $msg .= ' | أخطاء: ' . implode(' | ', array_slice($errors, 0, 5));
        return back()->with('success', $msg)->with('import_errors', $errors);
    }
}
