<?php
/**
 * Functions for handling json content in Symfony/HttpFoundation/Request object
 *
 * @version 0.0.1
 * @released 2017-08-22
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Bakay Omuraliev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use Symfony\Component\HttpFoundation\Request;

if (!is_callable('is_json_request')) {
	function is_json_request(Request $request): bool
	{
		return 0 === strpos($request->headers->get('Content-Type'), 'application/json');
	}
}

if (!is_callable('is_valid_json_request')) {
	function is_valid_json_request(Request $request): bool
	{
		if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
			json_decode($request->getContent(), true);
			return json_last_error() == JSON_ERROR_NONE;
		}
		return false;
	}
}

if (!is_callable('get_json_request')) {
	function get_json_request(Request $request): array
	{
		if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
			$data = json_decode($request->getContent(), true);
			if (json_last_error() == JSON_ERROR_NONE) {
				return $data;
			}
		}
		return array();
	}
}

if (!is_callable('extract_json_request')) {
	function extract_json_request(Request $request): Request
	{
		if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
			$data = json_decode($request->getContent(), true);
			if (json_last_error() == JSON_ERROR_NONE) {
				$request->request->replace($data);
			} else $request->request->replace();
		}
		return $request;
	}
}
