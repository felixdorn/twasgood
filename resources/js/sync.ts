import {Asset} from "@/types";
import axios, {AxiosError} from "axios";

export enum StatusIndicator {
    Updating = 'updating',
    Updated = 'updated',
    Error = 'error'
}

export class Sync {
    resourceType: string;
    resourceId: string | number;

    constructor(resourceType: string, resourceId: string | number) {
        this.resourceType = resourceType
        this.resourceId = resourceId
    }

    syncAsset(e?: InputEvent, options: {
        group?: string,
        asset?: Asset,
        onSuccess?: (d: Asset) => void,
        onError?: (err: AxiosError) => void
    } = {}) {
        this.updateStatus(StatusIndicator.Updating)

        let data = {}


        if (!e) {
            //
        } else if (e instanceof File) {
            data.asset = e
        } else if (e.target.type === 'file') {
            data.asset = e.target.files[0]
        } else {
            data.alt = e.target?.value
        }


        axios.post(
            route('console.assets.upload', {
                resource_type: this.resourceType,
                resource_id: this.resourceId,
                asset_id: options.asset?.id,
                group: options.group,
            }),
            data,
            {
                headers: {'Content-Type': 'multipart/form-data'},
            }
        ).then(res => {
            this.updateStatus(StatusIndicator.Updated)

            if (options.onSuccess) options.onSuccess(res.data)
        }).catch((err) => {
            // todo: this where we would retry
            if (options.onError) options.onError(err)
        })
    }

    updateStatus(newStatus: StatusIndicator) {
        const event = new StatusUpdateEvent('status:update')
        event.newStatus = newStatus

        if (document) {
            document.dispatchEvent(event)
        }
    }

    onStatusUpdate(cb: (status: StatusIndicator) => void) {
        statusListeners.push(cb)
    }

    orderAssets(assets: Asset[], options: {
        onSuccess?: (assets: Asset[]) => void,
        onError?: (err: AxiosError) => void
    } = {}) {
        this.updateStatus(StatusIndicator.Updating)

        axios.patch(
            route('console.assets.order'),
            {assets: assets.map(asset => asset.id)}
        ).then(res => {
            this.updateStatus(StatusIndicator.Updated)

            // if res data is object, make it an array
            if (res.data && !Array.isArray(res.data)) {
                res.data = Object.values(res.data)
            }

            if (options.onSuccess) options.onSuccess(res.data)
        }).catch((err) => {
            // todo: this where we would retry
            if (options.onError) options.onError(err)
        })
    }

    removeAsset(asset: Asset, options: {
        onSuccess?: (asset: Asset[]) => void,
        onError?: (err: AxiosError) => void
    } = {}) {
        this.updateStatus(StatusIndicator.Updating)

        axios.delete(
            route('console.assets.destroy', {
                resource_type: this.resourceType,
                resource_id: this.resourceId,
                asset: asset.id,
            })
        ).then(res => {
            this.updateStatus(StatusIndicator.Updated)

            if (options.onSuccess) options.onSuccess(res.data)
        }).catch((err) => {
            // todo: this where we would retry
            if (options.onError) options.onError(err)
        })
    }

    createAsset(options: {
        group: string,
        onSuccess?: (asset: Asset) => void,
        onError?: (err: AxiosError) => void
    }) {
        return this.syncAsset(undefined, options)
    }


}

class StatusUpdateEvent extends Event {
    newStatus: StatusIndicator
}

const statusListeners: ((status: StatusIndicator) => void)[] = []
if (document) {
    document.addEventListener('status:update', (event) => statusListeners.forEach(listener => {
        listener(event.newStatus);
    }))
}


export function useSync(resourceType: string, resourceId: string | number) {
    return new Sync(resourceType, resourceId)
}
