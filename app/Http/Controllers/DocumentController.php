<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Enums\DocumentStatusEnums;
use App\Enums\DocumentTypeEnums;
use App\Http\Requests\StoreDocumentRequest;;
use Illuminate\Support\Facades\Cache;
use \App\Http\Resources\DocumentResource;

class DocumentController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(Document::class, 'document');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Documents/Index', [
            'initialDocuments' => DocumentResource::collection(
                Cache::rememberForever('documents', function () {
                    return Document::with('documentable')->get();
                })
            ),
            'accounts' => \App\Http\Resources\AccountResource::collection(
                Cache::rememberForever('accounts', function () {
                    return \App\Models\Account::all();
                }),
            ),
            'clients' => \App\Http\Resources\ClientResource::collection(
                Cache::rememberForever('clients', function () {
                    return \App\Models\Client::all();
                }),
            ),
            'payments' => \App\Http\Resources\PaymentResource::collection(
                Cache::rememberForever('contributions', function () {
                    return \App\Models\Payment::where('type', \App\Enums\PaymentTypeEnums::CONTRIBUTION)
                        ->latest()->get();
                }),
            ),
            'claims' => \App\Http\Resources\ClaimResource::collection(
                Cache::rememberForever('claims', function () {
                    return \App\Models\Claim::all();
                }),
            ),
            'statuses' => DocumentStatusEnums::labels(),
            'types' => DocumentTypeEnums::labels(),
            'document' => session('document') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDocumentRequest $request)
    {
        $document = Document::create($request->validated());

        // Clear the cache to ensure the new document is available
        Cache::forget('documents');

        return redirect()->route('dashboard')
            ->with('success', 'Document created successfully.')
            ->with('document', new DocumentResource($document));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Inertia\Response
     */
    public function show(Document $document)
    {
        return inertia()->render('Documents/Show', [
            'document' => new DocumentResource($document),
            'statuses' => DocumentStatusEnums::labels(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentRequest  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreDocumentRequest $request, Document $document)
    {
        $document->update($request->validated());

        // Clear the cache to ensure the new document is available
        Cache::forget('documents');

        return redirect()->route('dashboard')
            ->with('success', 'Document updated successfully.')
            ->with('document', new DocumentResource($document));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Document $document)
    {
        $document->delete();

        // Clear the cache to ensure the new document is available
        Cache::forget('documents');

        return redirect()->route('dashboard')
            ->with('success', 'Document deleted successfully.');
    }
}