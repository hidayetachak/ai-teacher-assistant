<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('created_at', 'desc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'credits' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'recovery_payment' => 'required|in:yes,no',
        ]);

        $validatedData['features'] = json_encode($request->features);

        try {
            Package::create($validatedData);
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Package added successfully',
                    'redirect' => route('admin.packages.index')
                ]);
            }
            return redirect()->route('admin.packages.index')->with('success', 'Package added successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error creating package: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error creating package: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $package->features = json_decode($package->features, true) ?? [];
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'credits' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'recovery_payment' => 'required|in:yes,no',
        ]);

        try {
            $validatedData['features'] = json_encode($request->features);
            $package->update($validatedData);
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Package updated successfully',
                    'redirect' => route('admin.packages.index')
                ]);
            }
            return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error updating package: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error updating package: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        try {
            $package = Package::findOrFail($id);
            $validated = $request->validate([
                'is_active' => 'required|boolean'
            ]);

            $package->is_active = $validated['is_active'];
            $package->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Package status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating package status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function featureupdateStatus(Request $request, $id): JsonResponse
    {
        try {
            $package = Package::findOrFail($id);
            $validated = $request->validate([
                'is_featured' => 'required|boolean'
            ]);

            $package->is_featured = $validated['is_featured'];
            $package->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Featured status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating featured status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $package = Package::findOrFail($id);
            $package->delete();

            return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.packages.index')->with('error', 'Error deleting package: ' . $e->getMessage());
        }
    }
}