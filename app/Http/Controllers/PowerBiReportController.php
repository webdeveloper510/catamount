<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PowerBiReport;
use App\Services\PowerBiService;
use Illuminate\Support\Facades\Validator;

class PowerBiReportController extends Controller
{
    protected $powerBiService;

    public function __construct(PowerBiService $powerBiService)
    {
        $this->powerBiService = $powerBiService;
    }
    public function createPowerBIReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_name' => 'required|string|max:255',
            'group_id' => 'required|string|max:36',
            'report_id' => 'required|string|max:36',
            'dataset_id' => 'required|string|max:36',
            'embed_url' => 'required|url',
            'permissions' => 'required|string',
            'isRlsEnabled' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $powerBiReport = new PowerBiReport();
            $powerBiReport->report_name = $request->report_name;
            $powerBiReport->workspace_id = $request->workspace_id ? $request->workspace_id : null;
            $powerBiReport->PBI_group_id = $request->group_id;
            $powerBiReport->PBI_report_id = $request->report_id;
            $powerBiReport->PBI_dataset_id = $request->dataset_id;
            $powerBiReport->PBI_embed_url = $request->embed_url;
            $powerBiReport->permissions = $request->permissions;
            $powerBiReport->is_rls_enabled = $request->isRlsEnabled ? true : false;
            $powerBiReport->save();

            return redirect()->back()->with('success', 'Power BI Report Created Successfully.');
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function editPowerBIReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'powerbi_id' => 'required',
            'report_name' => 'required|string|max:255',
            'group_id' => 'required|string|max:36',
            'report_id' => 'required|string|max:36',
            'dataset_id' => 'required|string|max:36',
            'embed_url' => 'required|url',
            'permissions' => 'required|string',
            'isRlsEnabled' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $id = $request->powerbi_id;
        $powerBiReport = PowerBiReport::find($id);

        try {
            $powerBiReport->report_name = $request->report_name;
            $powerBiReport->workspace_id = $request->workspace_id ? $request->workspace_id : null;
            $powerBiReport->PBI_group_id = $request->group_id;
            $powerBiReport->PBI_report_id = $request->report_id;
            $powerBiReport->PBI_dataset_id = $request->dataset_id;
            $powerBiReport->PBI_embed_url = $request->embed_url;
            $powerBiReport->permissions = $request->permissions;
            $powerBiReport->is_rls_enabled = $request->isRlsEnabled ? true : false;
            $powerBiReport->save();

            return redirect()->back()->with('success', 'Power BI Report Updated Successfully.');
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deletePowerBIReport(Request $request)
    {
        $id = $request->id;
        $report = PowerBiReport::find($id);

        if ($report) {
            $report->delete();
            return response()->json(['success' => 'Power BI Report deleted successfully']);
        } else {
            return response()->json(['success' => 'Power BI Report not found']);
        }
    }

    public function showPowerBIReport($id)
    {
        // Get Power BI Report
        $reportId = base64_decode($id);
        $report = PowerBiReport::findOrFail($reportId);

        // Get access token, report id and embed url
        $accessToken = $this->powerBiService->getAccessToken();
        $reportId = $report->PBI_report_id;
        $embedUrl = $report->PBI_embed_url;
        $permissions = 'View';
        $tokenType = 'Bearer';

        return view('powerbi.index', compact('accessToken', 'reportId', 'embedUrl', 'permissions', 'tokenType'));
    }
}
