<?php

namespace App\Http\Controllers;

use App\WordpressSite;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WordpressController extends ControllerUser
{
    /**
     * @return View
     */
    public function getIndex()
    {
        return view('dashboard.wordpress');
    }

    /**
     * @return Collection|array
     */
    public function getSites()
    {
        return $this->user->wordpress()->get();
    }

    /**
     * @param Request $request
     *
     * @return Collection|array
     */
    public function postAdd(Request $request)
    {
        $link = $request->get('link');

        if (WordpressSite::byLink($link)) {
            return [
                'error' => 'This site already exists',
            ];
        }

        $this->user->addWordpress($link);

        return $this->getSites();
    }

    /**
     * @param int $id
     *
     * @return Collection|array
     */
    public function getRemove($id)
    {
        $site = $this->user->wordpressById($id);
        if ($site) {
            $site->delete();
        }

        return $this->getSites();
    }
}
