@extends('errors::layout')

@section('title', __('errors.403'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
