<?php
/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 17/08/2016
 * Time: 01:12 AM
 */

namespace Notes\Controllers;


use Notes\Models\Notes;

class NotesController extends BaseController
{
    public function getAll()
    {
        $notes = Notes::find();
        if (!$notes->count()) {
            $this->setResponse(['type' => 'SUCCESS', 'message' => 'THERE ARE NO NOTES'], $notes);
            return $this->response;
        }
        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], $notes->toArray());
        return $this->response;

    }

    public function getById($id)
    {
        $notes = Notes::findFirstByNoteId($id);
        if (!$notes) {
            $this->setResponse(['type' => 'SUCCESS', 'message' => 'NOTE NOT FOund'], []);
            return $this->response;
        }
        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], $notes->toArray());
        return $this->response;

    }

    public function create()
    {
        $note = new Notes();

        $note->title = $this->request->getPost("title", "string");
        $note->body = $this->request->getPost("body", "string");
        $note->user_id = $this->request->getPost("user_id", "int");
        $note->status = $this->request->getPost("status", "string");
        $note->color = $this->request->getPost("color", "string");
        $note->type = $this->request->getPost("type", "string");
        $note->created_at = date("Y-m-d H:i:s");

        $errors = [];

        if (!$note->save()) {
            foreach($note->getMessages() as $error) {
                $errors[] = $error;
            }
            $this->setResponse(['type' => 'ERROR', 'message' => 'SOMETHING WENT WRONG'], $errors, 400);
            return $this->response;
        }

        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], $note->toArray());
        return $this->response;
    }
    public function edit($id)
    {
        $note = Notes::findFirstByNoteId($id);
        if (!$note) {
            $this->setResponse(['type' => 'SUCCESS', 'message' => 'NOTE NOT FOUND'], []);
            return $this->response;
        }

        $note->title = $this->request->getPost("title", "string");
        $note->body = $this->request->getPost("body", "string");
        $note->user_id = $this->request->getPost("user_id", "int");
        $note->status = $this->request->getPost("status", "string");
        $note->color = $this->request->getPost("color", "string");
        $note->type = $this->request->getPost("type", "string");
        $note->updated_at = date("Y-m-d H:i:s");

        $errors = [];

        if (!$note->update()) {
            foreach($note->getMessages() as $error) {
                $errors[] = $error;
            }
            $this->setResponse(['type' => 'ERROR', 'message' => 'SOMETHING WENT WRONG'], $errors, 400);
            return $this->response;
        }

        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], $note->toArray());
        return $this->response;
    }

    public function delete($id)
    {
        $note = Notes::findFirst(["note_id" => $id]);
        if (!$note) {
            $this->setResponse(['type' => 'SUCCESS', 'message' => 'NOTE NOT FOUND'], []);
            return $this->response;
        }
        $note->delete();

        $this->setResponse(['type' => 'SUCCESS', 'message' => 'NOTE DELETED'], []);
        return $this->response;
    }

}