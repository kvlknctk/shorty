import React, {useState} from 'react';
import {Head} from '@inertiajs/inertia-react';
import axiosEngine from "@/Engines/axiosEngine";

export default function SwapUrl(props) {

    const [url, setUrl] = useState('');
    const [urls, setUrls] = useState([]);

    const handlePostIt = () => {
        axiosEngine.post('/create', {url})
            .then(res => res.data)
            .then((response) => {
                setUrls([...urls, response.data.shortedUrl]);
            });
    }


    return (
        <>
            <Head title="Swap Url"/>
            <div
                className="smartLayout">
                <div className="lg:w-full sm:mx-auto lg:px-32 ">
                    <div className="mb-6 ">
                        <label htmlFor="longUrl"
                               className="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Paste Long URL
                        </label>
                        <input autoFocus value={url}
                               onChange={e => setUrl(e.target.value)}
                               type="text" id="longUrl"
                               className="urlInput"
                               placeholder="https://"
                        />
                        <button type="button" disabled={!url} onClick={() => handlePostIt()}
                                className="createButton">Post it
                        </button>

                        {
                            urls.map((url, index) => (
                                <div key={index} className="text-white select-all p-2 border rounded my-2 bg-gray-600">{url}</div>
                            ))
                        }

                    </div>
                </div>
            </div>
        </>
    );
}
