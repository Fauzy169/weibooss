<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$defaults = [
			['name' => 'Nike',          'file' => 'client-01.png'],
			['name' => 'Adidas',        'file' => 'client-02.png'],
			['name' => 'Puma',          'file' => 'client-03.png'],
			['name' => 'Reebok',        'file' => 'client-04.png'],
			['name' => 'New Balance',   'file' => 'client-05.png'],
			['name' => 'Under Armour',  'file' => 'client-06.png'],
		];

		// Ensure target directory exists on public disk
		Storage::disk('public')->makeDirectory('brands');

		foreach ($defaults as $row) {
			$slug = Str::slug($row['name']);
			$src  = public_path('assets/images/brands/' . $row['file']);
			$dstRel = 'brands/' . $row['file'];

			if (File::exists($src) && !Storage::disk('public')->exists($dstRel)) {
				Storage::disk('public')->put($dstRel, File::get($src));
			}

			Brand::updateOrCreate(
				['slug' => $slug],
				[
					'name' => $row['name'],
					'active' => true,
					'image' => Storage::disk('public')->exists($dstRel) ? $dstRel : null,
				]
			);
		}
	}
}
