import React from 'react';

export default function ShortedUrlItem({ url, shortedUrl }) {
    return (
        <div className="text-white select-all p-2 border rounded my-2 bg-gray-600">{url}</div>
    );
}
