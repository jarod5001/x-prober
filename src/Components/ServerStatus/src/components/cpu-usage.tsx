import React from 'react'
import CardGrid from '@/Card/src/components/card-grid'
import { gettext } from '@/Language/src'
import store from '../stores'
import ProgressBar from '@/ProgressBar/src/components'
import template from '@/Helper/src/components/template'
import { observer } from 'mobx-react-lite'

const CpuUsage = observer(() => {
  const { cpuUsage } = store
  const { idle } = cpuUsage

  return (
    <CardGrid name={gettext('CPU usage')} tablet={[1, 1]}>
      <ProgressBar
        title={template(
          gettext(
            'idle: ${idle} \nnice: ${nice} \nsys: ${sys} \nuser: ${user}'
          ),
          cpuUsage
        )}
        value={100 - idle}
        max={100}
        isCapacity={false}
      />
    </CardGrid>
  )
})

export default CpuUsage
