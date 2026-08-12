<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CaseStudyDataTable;
use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaseStudyStoreRequest;
use App\Http\Requests\Admin\CaseStudyUpdateRequest;
use App\Models\CaseStudy;
use App\Services\CaseStudyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    use RespondsToAdminAjax;

    public function __construct(
        private readonly CaseStudyService $caseStudies,
    ) {}

    /**
     * Render the case studies index or return Yajra DataTables JSON for AJAX.
     */
    public function index(Request $request, CaseStudyDataTable $dataTable): View|JsonResponse
    {
        if ($this->wantsAdminJson($request) || $request->ajax()) {
            return $dataTable->ajax($request);
        }

        return view('admin.case-studies.index', [
            'columns' => CaseStudyDataTable::columns(),
        ]);
    }

    /**
     * Show the create-case-study form.
     */
    public function create(): View
    {
        return view('admin.case-studies.form', [
            'caseStudy' => $this->caseStudies->newDraft(),
            'defaultSections' => $this->caseStudies->defaultSections(),
        ]);
    }

    /**
     * Persist a new case study and optional featured image.
     */
    public function store(CaseStudyStoreRequest $request): JsonResponse|RedirectResponse
    {
        $caseStudy = $this->caseStudies->create($request);

        return $this->adminSuccess(
            $request,
            'Case study',
            'created',
            'admin.case-studies.edit',
            $caseStudy,
            ['case_study' => ['id' => $caseStudy->id, 'slug' => $caseStudy->slug]]
        );
    }

    /**
     * Show the edit form for an existing case study.
     */
    public function edit(CaseStudy $caseStudy): View
    {
        return view('admin.case-studies.form', [
            'caseStudy' => $caseStudy,
            'defaultSections' => $this->caseStudies->defaultSections(),
        ]);
    }

    /**
     * Update a case study and replace the featured image when uploaded.
     */
    public function update(CaseStudyUpdateRequest $request, CaseStudy $caseStudy): JsonResponse|RedirectResponse
    {
        $caseStudy = $this->caseStudies->update($request, $caseStudy);

        return $this->adminSuccess(
            $request,
            'Case study',
            'updated',
            'admin.case-studies.edit',
            $caseStudy,
            ['case_study' => ['id' => $caseStudy->id, 'slug' => $caseStudy->slug]]
        );
    }

    /**
     * Soft-delete a case study from the catalog.
     */
    public function destroy(Request $request, CaseStudy $caseStudy): JsonResponse|RedirectResponse
    {
        $this->caseStudies->delete($caseStudy);

        return $this->adminSuccess($request, 'Case study', 'deleted', 'admin.case-studies.index');
    }
}
