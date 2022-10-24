import React, {useState} from 'react';
import {Head} from '@inertiajs/inertia-react';
import axiosEngine from "@/Engines/axiosEngine";
import ShortedUrlItem from "@/Components/ShortedUrlItem";

export default function SwapUrl(props) {

    const [urls, setUrls] = useState([]);

    const [formData, setFormData] = useState({
        url: '',
        provider: 'tiny'
    });

    const handlePostIt = () => {
        axiosEngine.post('/short', formData)
            .then(res => res.data)
            .then((response) => {
                setUrls([...urls, response]);
            }).catch(err => {
            alert(err.response.data.message)
        });
    }

    function handleProviderChange(e) {
        setFormData({
            ...formData,
            provider: e.target.value
        });
    }

    function handleUrl(e) {
        setFormData({
            ...formData,
            url: e.target.value
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
                        <div className="flex flex-row">

                            <input autoFocus value={formData.url}
                                   onChange={e => handleUrl(e)}
                                   type="text" id="longUrl"
                                   className="urlInput flex-[2]"
                                   placeholder="https://"
                            />

                            <select id="provider" value={formData.provider} className="shorterProviderSelector flex-[1]"
                                    onChange={e => handleProviderChange(e)}>
                                <option value="tiny">TinyURL</option>
                                <option value="bitly">Bitly</option>
                            </select>

                        </div>
                        <button type="button" disabled={!formData.url} onClick={() => handlePostIt()}
                                className="createButton">Post it
                        </button>
                        <div className="text-xs text-gray-600 text-center ">
                            {props.dummyAppVersion}
                        </div>

                        {urls.map((url, index) => <ShortedUrlItem key={index} url={url.shortedUrl}/>)}

                    </div>
                </div>
            </div>
        </>
    );
}
