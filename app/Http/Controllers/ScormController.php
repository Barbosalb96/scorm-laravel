<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Peopleaps\Scorm\Exception\InvalidScormArchiveException;
use Peopleaps\Scorm\Exception\StorageNotFoundException;
use Peopleaps\Scorm\Manager\ScormManager;
use Peopleaps\Scorm\Model\ScormModel;
use function Symfony\Component\String\s;
use function Symfony\Component\String\u;

class ScormController
{
    /** @var ScormManager $scormManager */
    private $scormManager;

    /**
     * ScormController constructor.
     * @param ScormManager $scormManager
     */
    public function __construct(ScormManager $scormManager)
    {
        $this->scormManager = $scormManager;
    }

    // ScormController.php

    public function show($id)
    {
        // Recupere o objeto ScormModel com base no ID ou como desejar
        $scorm = ScormModel::findOrFail($id);

        return view('view', compact('scorm'));
    }


    public function import(Request $request)
    {
        $uploadedFile = $request->file('scorm_package');
        try {
            $scorm = $this->scormManager->uploadScormArchive($uploadedFile);
//      dd($scorm->id);
//            $item = ScormModel::with('scos')->findOrFail($scorm->id);
            // response helper function from base controller reponse json.
//            return $item;
            return view('view',['scorm' => $scorm]);
//            return redirect()->route('view', ['id' => $scorm->id]);
        } catch (InvalidScormArchiveException $ex) {
            // Tratar erro na importação de pacote SCORM inválido
            return response()->json(['error' => 'Pacote SCORM inválido.']);
        }
    }

    public function store(Request $request)
    {
        try {
            $scorm = $this->scormManager->uploadScormArchive($request->file('file'));
            // handle scorm runtime error msg
        } catch (InvalidScormArchiveException|StorageNotFoundException $ex) {
            return $this->respondCouldNotCreateResource(trans('scorm.' . $ex->getMessage()));
        }

        // response helper function from base controller response json.
        return $this->respond(ScormModel::with('scos')->whereUuid($scorm['uuid'])->first());
    }

    public function saveProgress(Request $request)
    {
        // TODO save user progress...
    }
}
